<?php

namespace App\Http\Controllers\Staff;

use App\Models\Subscription;
use App\Models\Customer;
use App\Models\Plan;
use App\Services\MailjetEmailService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SubscriptionController extends Controller
{
    protected $mailjetService;

    public function __construct(MailjetEmailService $mailjetService)
    {
        $this->mailjetService = $mailjetService;
    }

    /**
     * Display a listing of subscriptions.
     */
    public function index()
    {
        $subscriptions = Subscription::with(['customer', 'plan', 'subscriptionFeatures'])
            ->latest()
            ->paginate(15);
            
        return view('staff.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new subscription.
     */
    public function create()
    {
        $customers = Customer::where('is_active', 1)->get();
        $plans = Plan::where('is_visible', 1)->get();
        
        return view('staff.subscriptions.create', compact('customers', 'plans'));
    }

    /**
     * Store a newly created subscription.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plan_id' => 'required|exists:plans,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'grace_date' => 'nullable|date|after:end_date',
        ]);

        // Check if customer already has an active subscription
        $existingSubscription = Subscription::where('customer_id', $validated['customer_id'])
            ->where('end_date', '>', now())
            ->first();

        if ($existingSubscription) {
            return back()->with('error', 'Customer already has an active subscription.')
                ->withInput();
        }

        $subscription = Subscription::create([
            'customer_id' => $validated['customer_id'],
            'plan_id' => $validated['plan_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'grace_date' => $validated['grace_date'],
        ]);

        // Update customer's plan
        Customer::where('id', $validated['customer_id'])
            ->update(['plan' => $validated['plan_id']]);

        // Create subscription features
        $this->createSubscriptionFeatures($subscription, $validated['plan_id']);

        // Send email notification via Mailjet
        try {
            $customer = Customer::find($validated['customer_id']);
            $this->mailjetService->sendSubscriptionEmail($customer, $subscription, 'created');
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send subscription creation email via Mailjet: ' . $e->getMessage());
        }

        return redirect()->route('staff.subscriptions.show', ['locale' => app()->getLocale(), 'subscription' => $subscription])
            ->with('success', 'Subscription created successfully and notification email sent.');
    }

    /**
     * Create subscription features based on plan features.
     */
    private function createSubscriptionFeatures(Subscription $subscription, int $planId)
    {
        $plan = Plan::find($planId);
        if (!$plan) {
            \Log::warning("Plan not found for ID: {$planId}");
            return;
        }

        // Get plan features
        $planFeatures = $plan->features()->first();
        
        if (!$planFeatures) {
            \Log::warning("No plan features found for plan ID: {$planId}");
            return;
        }

        // Get active features from plan
        $activeFeatures = $planFeatures->activeFeatures();
        
        foreach ($activeFeatures as $featureName) {
            // Create subscription feature
            \App\Models\SubscriptionFeature::create([
                'subscription_id' => $subscription->id,
                'feature_id' => $this->getFeatureId($featureName),
                'feature_name' => $featureName,
                'feature_description' => $this->getFeatureDescription($featureName),
                'feature_limit' => $this->getFeatureLimit($planFeatures, $featureName),
                'is_enabled' => true,
                'feature_config' => $this->getFeatureConfig($planFeatures, $featureName),
            ]);
        }
    }

    /**
     * Get feature ID (create if doesn't exist).
     */
    private function getFeatureId(string $featureName): int
    {
        $featureMap = [
            'Accounts' => 1,
            'CRM' => 2,
            'POS' => 3,
            'HRM' => 4,
            'Project' => 5,
            'Manufacture' => 6,
        ];
        
        return $featureMap[$featureName] ?? 999;
    }

    /**
     * Get feature description.
     */
    private function getFeatureDescription(string $featureName): string
    {
        $descriptions = [
            'Accounts' => 'Accounting and financial management module',
            'CRM' => 'Customer relationship management module',
            'POS' => 'Point of sale system module',
            'HRM' => 'Human resource management module',
            'Project' => 'Project management module',
            'Manufacture' => 'Manufacturing management module',
        ];
        
        return $descriptions[$featureName] ?? 'Additional feature';
    }

    /**
     * Get feature limit based on plan features.
     */
    private function getFeatureLimit(\App\Models\PlanFeature $planFeatures, string $featureName): ?int
    {
        if ($featureName === 'Max Users' || $featureName === 'max_user') {
            return $planFeatures->max_user;
        }
        
        return null;
    }

    /**
     * Get feature configuration.
     */
    private function getFeatureConfig(\App\Models\PlanFeature $planFeatures, string $featureName): array
    {
        $config = [];
        
        switch ($featureName) {
            case 'Accounts':
                $config['modules'] = ['general_ledger', 'accounts_payable', 'accounts_receivable'];
                break;
            case 'CRM':
                $config['modules'] = ['leads', 'contacts', 'opportunities'];
                break;
            case 'POS':
                $config['modules'] = ['sales', 'inventory', 'reports'];
                break;
            case 'HRM':
                $config['modules'] = ['employees', 'payroll', 'attendance'];
                break;
            case 'Project':
                $config['modules'] = ['tasks', 'milestones', 'resources'];
                break;
            case 'Manufacture':
                $config['modules'] = ['production', 'inventory', 'quality_control'];
                break;
        }
        
        return $config;
    }

    /**
     * Display the specified subscription.
     */
    public function show($locale, Subscription $subscription)
    {
        $subscription->load(['customer', 'plan', 'subscriptionFeatures']);
        return view('staff.subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified subscription.
     */
    public function edit($locale, Subscription $subscription)
    {
        $customers = Customer::where('is_active', 1)->get();
        $plans = Plan::where('is_visible', 1)->get();
        
        return view('staff.subscriptions.edit', compact('subscription', 'customers', 'plans'));
    }

    /**
     * Update the specified subscription.
     */
    public function update(Request $request, $locale, Subscription $subscription)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plan_id' => 'required|exists:plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'grace_date' => 'nullable|date|after:end_date',
        ]);

        $subscription->update([
            'customer_id' => $validated['customer_id'],
            'plan_id' => $validated['plan_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'grace_date' => $validated['grace_date'],
        ]);

        // Update customer's plan
        Customer::where('id', $validated['customer_id'])
            ->update(['plan' => $validated['plan_id']]);

        return redirect()->route('staff.subscriptions.show', ['locale' => $locale, 'subscription' => $subscription])
            ->with('success', 'Subscription updated successfully.');
    }

    /**
     * Remove the specified subscription.
     */
    public function destroy($locale, Subscription $subscription)
    {
        // Remove plan from customer
        Customer::where('id', $subscription->customer_id)
            ->update(['plan' => null]);

        $subscription->delete();

        return redirect()->route('staff.subscriptions.index', ['locale' => $locale])
            ->with('success', 'Subscription deleted successfully.');
    }

    /**
     * Renew a subscription.
     */
    public function renew($locale, Subscription $subscription)
    {
        $plan = $subscription->plan;
        $duration = $plan->duration ?? 'month'; // Default to month if not set
        
        // Calculate new end date based on plan duration
        $newEndDate = match($duration) {
            'month' => $subscription->end_date->copy()->addMonth(),
            'year' => $subscription->end_date->copy()->addYear(),
            'one_time' => $subscription->end_date->copy()->addYear(), // Treat one_time as yearly
            'lifetime' => $subscription->end_date->copy()->addYears(100), // Lifetime = 100 years
            default => $subscription->end_date->copy()->addMonth(),
        };

        // Calculate grace date (7 days after new end date)
        $newGraceDate = $newEndDate->copy()->addDays(7);

        $subscription->update([
            'end_date' => $newEndDate,
            'grace_date' => $newGraceDate,
        ]);

        // Send email notification via Mailjet
        try {
            $customer = $subscription->customer;
            $this->mailjetService->sendSubscriptionEmail($customer, $subscription, 'renewed');
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send subscription renewal email via Mailjet: ' . $e->getMessage());
        }

        return back()->with('success', 'Subscription renewed successfully and notification email sent.');
    }

    /**
     * Cancel a subscription.
     */
    public function cancel($locale, Subscription $subscription)
    {
        // Only cancel if subscription is still active
        if (!$subscription->isActive()) {
            return back()->with('error', 'Cannot cancel an inactive subscription.');
        }

        $subscription->update([
            'end_date' => now(),
            'grace_date' => now()->addDays(7), // 7 days grace period
        ]);

        // Send email notification via Mailjet
        try {
            $customer = $subscription->customer;
            $this->mailjetService->sendSubscriptionEmail($customer, $subscription, 'cancelled');
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send subscription cancellation email via Mailjet: ' . $e->getMessage());
        }

        return back()->with('success', 'Subscription cancelled successfully and notification email sent.');
    }

    /**
     * Extend subscription grace period.
     */
    public function extendGrace($locale, Subscription $subscription)
    {
        // Only extend grace if subscription is in grace period or expired
        if ($subscription->isActive()) {
            return back()->with('error', 'Cannot extend grace period for an active subscription.');
        }

        $newGraceDate = $subscription->grace_date ? 
            $subscription->grace_date->copy()->addDays(7) : 
            now()->addDays(7);

        $subscription->update(['grace_date' => $newGraceDate]);

        return back()->with('success', 'Grace period extended successfully.');
    }

    /**
     * Get subscription statistics (AJAX).
     */
    public function getStats()
    {
        $stats = [
            'total' => Subscription::count(),
            'active' => Subscription::active()->count(),
            'expired' => Subscription::expired()->count(),
            'in_grace' => Subscription::inGracePeriod()->count(),
        ];

        return response()->json($stats);
    }
}

