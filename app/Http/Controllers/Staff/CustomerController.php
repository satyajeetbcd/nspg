<?php

namespace App\Http\Controllers\Staff;

use App\Mail\CustomerStatusNotification;
use App\Mail\PlanAssignmentNotification;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\SubscriptionFeature;
use App\Services\MailjetEmailService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    protected $mailjetService;

    public function __construct(MailjetEmailService $mailjetService)
    {
        $this->mailjetService = $mailjetService;
    }

    /**
     * Display customers list.
     */
    public function index($locale)
    {
        $customers = Customer::with('plan')->latest()->paginate(15);
        return view('staff.customers.index', compact('customers'));
    }

    /**
     * Show create customer form.
     */
    public function create($locale)
    {
        $plans = Plan::where('is_disable', false)->get();
        return view('staff.customers.create', compact('plans'));
    }

    /**
     * Store new customer.
     */
    public function store(Request $request, $locale)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:8',
            'plan' => 'nullable|exists:plans,id',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Ensure customer has a plan - assign default plan if none specified
        if (!isset($validated['plan']) || !$validated['plan']) {
            $defaultPlan = Plan::where('id', 1)->first();

            $validated['plan'] = $defaultPlan->id;
        }

        $customer = Customer::create($validated);

        // Create subscription for new customer
        $plan = Plan::find($validated['plan']);
        if ($plan) {
            $this->createOrUpdateSubscription($customer, $plan);
        }

        return response()->json(['message' => 'Customer created successfully with plan assigned.']);
    }

    /**
     * Show customer details.
     */
    public function show($locale, Customer $customer)
    {
        $customer->load('plan', 'invoices');
        return view('staff.customers.show', compact('customer'));
    }

    /**
     * Show edit customer form.
     */
    public function edit($locale, Customer $customer)
    {
        $customer->load('plan');
        $plans = Plan::whereNull('is_disable')->get();
        return view('staff.customers.edit', compact('customer', 'plans'));
    }

    /**
     * Update customer.
     */
    public function update(Request $request, $locale, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'plan' => 'nullable|exists:plans,id',
            'is_active' => 'boolean',
        ]);

        $customer->update($validated);
        return response()->json(['message' => 'Customer updated successfully.']);
    }

    /**
     * Delete customer.
     */
    public function destroy($locale, Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully.']);
    }

    /**
     * Activate customer.
     */
    public function activate($locale, Customer $customer)
    {
        $customer->update(['is_active' => 1]);

        // Send email notification
        try {
            Mail::to($customer->email)->send(new CustomerStatusNotification($customer, 'activated'));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            Log::error('Failed to send customer activation email: ' . $e->getMessage());
        }

        return back()->with('success', 'Customer activated successfully and notification email sent.');
    }

    /**
     * Deactivate customer.
     */
    public function deactivate($locale, Customer $customer)
    {
        $customer->update(['is_active' => 0]);

        // Send email notification
        try {
            Mail::to($customer->email)->send(new CustomerStatusNotification($customer, 'deactivated'));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            Log::error('Failed to send customer deactivation email: ' . $e->getMessage());
        }

        return back()->with('success', 'Customer deactivated successfully and notification email sent.');
    }

    /**
     * Verify customer email.
     */
    public function verifyEmail($locale, Customer $customer)
    {
        $customer->update(['email_verified_at' => now()]);

        return back()->with('success', 'Customer email verified successfully.');
    }

    /**
     * Show customer subscription.
     */
    public function subscription($locale)
    {
        // Get subscriptions instead of customers for the new view
        $subscriptions = \App\Models\Subscription::with(['customer', 'plan'])
            ->latest()
            ->paginate(15);

        return view('staff.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show plan assignment form.
     */
    public function showAssignPlan($locale, Customer $customer)
    {
        if ($customer->is_active == false || !$customer->email_verified_at ) {
            return redirect()->back()->with('error','Plan assignment is not permitted for this customer'. $customer->is_active == false ? "Cusomer Not Activated" : "Customer Email Not Verified");
        }
        $customer->load('plan');
        $plans = Plan::where('is_disable',false)->get();
        return view('staff.customers.assign-plan', compact('customer', 'plans'));
    }

    /**
     * Assign plan to customer.
     */
    public function assignPlan(Request $request, $locale, Customer $customer)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $oldPlanId = $customer->plan;
        $newPlan = Plan::find($validated['plan_id']);

        $customer->update(['plan' => $validated['plan_id']]);

        // Create or update subscription
        $this->createOrUpdateSubscription($customer, $newPlan);

        // Determine action type for email
        $action = 'assigned';
        if ($oldPlanId) {
            $oldPlan = Plan::find($oldPlanId);
            if ($oldPlan && $newPlan) {
                // Simple comparison - you can enhance this with plan tiers/levels
                $action = $newPlan->id > $oldPlan->id ? 'upgraded' : 'downgraded';
            }
        }

        // Send email notification via Mailjet
        try {
            $this->mailjetService->sendPlanAssignmentEmail($customer, $newPlan, $action);
        } catch (\Exception $e) {
            // Log error but don't fail the request
            Log::error('Failed to send plan assignment email via Mailjet: ' . $e->getMessage());
        }

        return response()->json(['message'=> 'Plan assigned successfully and notification email sent.']);
    }

    /**
     * Create or update subscription for customer.
     */
    private function createOrUpdateSubscription(Customer $customer, Plan $plan)
    {
        // Check if customer already has an active subscription
        $existingSubscription = \App\Models\Subscription::where('customer_id', $customer->id)
            ->where('end_date', '>', now())
            ->first();

        if ($existingSubscription) {
            // Update existing subscription
            $existingSubscription->update([
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'notes' => 'Plan updated via customer management',
            ]);

            // Update subscription features
            $this->updateSubscriptionFeatures($existingSubscription, $plan);
        } else {
            // Create new subscription
            $startDate = now();
            $endDate = match ($plan->duration) {
                'day' => $startDate->copy()->addDay(),
                'week' => $startDate->copy()->addWeek(),
                'month' => $startDate->copy()->addMonth(),
                'quarter' => $startDate->copy()->addMonths(3),
                'year' => $startDate->copy()->addYear(),
                default => $startDate->copy()->addMonth(),
            };
            $graceDate = $endDate->copy()->addDays(7);

            $subscription = \App\Models\Subscription::create([
                'customer_id' => $customer->id,
                'plan_id' => $plan->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'grace_date' => $graceDate,
                'status' => 'active',
                'amount' => $plan->price,
                'currency' => 'USD',
                'notes' => 'Created via customer plan assignment',
            ]);

            // Create subscription features
            $this->createSubscriptionFeatures($subscription, $plan);
        }
    }

    /**
     * Create subscription features based on plan features.
     */
    private function createSubscriptionFeatures(\App\Models\Subscription $subscription, Plan $plan)
    {
        // Get plan features
        $planFeatures = $plan->features()->first();

        if (!$planFeatures) {
            Log::warning("No plan features found for plan ID: {$plan->id}");
            return;
        }

        // Get active features from plan
        $activeFeatures = $planFeatures->activeFeatures();
        $newSubscription = SubscriptionFeature::create([
            'subscription_id' => $subscription->id,
            'plan_id' => $planFeatures->plan_id, // remove space!
            'max_user' => $planFeatures->max_user, // ⚠️ your dump shows max_user (not max_users)
            'module_account' => $planFeatures->module_account,
            'module_crm' => $planFeatures->module_crm,
            'module_pos' => $planFeatures->module_pos,
            'module_hrm' => $planFeatures->module_hrm,
            'more_featrues' => $planFeatures->more_featrues, // typo in DB column
            'module_project' => $planFeatures->module_project,
            'module_manfucture' => $planFeatures->module_manfucture, // you also have this in DB
        ]);
    }

    /**
     * Update subscription features based on new plan.
     */
    private function updateSubscriptionFeatures(\App\Models\Subscription $subscription, Plan $plan)
    {
        // Remove existing subscription features
        $subscription->subscriptionFeatures()->delete();

        // Create new subscription features
        $this->createSubscriptionFeatures($subscription, $plan);
    }

    /**
     * Get feature ID (create if doesn't exist).
     */
    private function getFeatureId(string $featureName): int
    {
        // For now, we'll use a simple mapping
        // In a real system, you might have a features table
        $featureMap = [
            'Accounts' => 1,
            'CRM' => 2,
            'POS' => 3,
            'HRM' => 4,
            'Project' => 5,
            'Manufacture' => 6,
        ];

        return $featureMap[$featureName] ?? 999; // Default feature ID
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
        // For max_user feature, get the limit from plan
        if ($featureName === 'Max Users' || $featureName === 'max_user') {
            return $planFeatures->max_user;
        }

        // For other features, return null (unlimited) or specific limits
        return null;
    }

    /**
     * Get feature configuration.
     */


    /**
     * Remove plan from customer.
     */
    public function removePlan($locale, Customer $customer)
    {
        $oldPlan = $customer->plan()->first();
        $customer->update(['plan' => null]);

        // Send email notification
        try {
            Mail::to($customer->email)->send(new PlanAssignmentNotification($customer, $oldPlan, 'removed'));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            Log::error('Failed to send plan removal email: ' . $e->getMessage());
        }

        return back()->with('success', 'Plan removed successfully and notification email sent.');
    }

    /**
     * Search customers (AJAX).
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $customers = Customer::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($customers);
    }

    /**
     * Get customer statistics for dashboard.
     */
    public function getStats()
    {
        $stats = [
            'total' => Customer::count(),
            'active' => Customer::where('is_active', true)->count(),
            'inactive' => Customer::where('is_active', false)->count(),
            'verified' => Customer::whereNotNull('email_verified_at')->count(),
            'unverified' => Customer::whereNull('email_verified_at')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Export customers data.
     */
    public function export(Request $request)
    {
        $customers = Customer::with('plan')->get();

        $filename = 'customers_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($customers) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Status', 'Plan', 'Created At']);

            // CSV Data
            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->id,
                    $customer->name,
                    $customer->email,
                    $customer->phone,
                    $customer->is_active ? 'Active' : 'Inactive',
                    $customer->plan ? $customer->plan->name : 'No Plan',
                    $customer->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
