<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Country;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $customer = Customer::with(['companies', 'subscriptions.plan.features', 'subscriptions.plan.prices.currency'])->find($customer->id);
        $company = $customer->primaryCompany;

        // Get current subscription and plan
        $currentSubscription = $customer->currentSubscription();
        $currentPlan = $customer->getPlan()?->first();

        // Ensure plan features are loaded
        if ($currentPlan) {
            $currentPlan->load('features');
        }

        // Get available plans for upgrade
        $availablePlans = Plan::with(['features', 'prices.currency'])
            ->where('is_visible', true)
            ->where('is_disable', false)
            ->get();

        // Get customer's country (default to Saudi Arabia)
        $customerCountry = Country::where('code', 'SA')->first();
        if (!$customerCountry) {
            $customerCountry = Country::first();
        }

        return view('customer.subscription', compact(
            'customer',
            'company',
            'currentSubscription',
            'currentPlan',
            'availablePlans',
            'customerCountry'
        ));
    }

    public function availablePlans()
    {
        // Redirect to the new plan requests page to avoid duplication
        return redirect()->route('customer.plan-requests.index');
    }

    public function billing()
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        // Get billing information
        $paymentMethods = []; // TODO: Implement payment methods when payment gateway is integrated

        $nextBillingDate = null;
        $currentSubscription = $customer->currentSubscription();
        if ($currentSubscription) {
            $nextBillingDate = $currentSubscription->end_date;
        }

        return view('customer.billing', compact(
            'customer',
            'paymentMethods',
            'nextBillingDate',
            'currentSubscription'
        ));
    }

    public function history()
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        // Get subscription history
        $subscriptionHistory = $customer->subscriptions()
            ->with(['plan', 'plan.features'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get invoice history
        $invoiceHistory = $customer->invoices()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.subscription-history', compact(
            'customer',
            'subscriptionHistory',
            'invoiceHistory'
        ));
    }

    public function upgrade(Request $request, $planId)
    {
        $locale = app()->getLocale();
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();
        $plan = Plan::findOrFail($planId);

        // Check if the plan exists and is available
        if (!$plan || $plan->is_disable || !$plan->is_visible) {
            return redirect()->back()->with('error', 'The selected plan is not available.');
        }

        // Check if customer already has this plan
        $currentPlan = $customer->getPlan()?->first();
        if ($currentPlan && $currentPlan->id == $plan->id) {
            return redirect()->back()->with('info', 'You are already subscribed to this plan.');
        }

        // Redirect to the new plan request system with prefilled plan
        return redirect()->route('customer.plan-requests.index', ['locale' => $locale, 'plan' => $planId])
            ->with('info', 'Please complete your plan upgrade through our secure order system.');
    }

    /**
     * Show upgrade form for a specific plan (GET request)
     */
    public function showUpgrade($planId)
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();
        $customer = Customer::with(['subscriptions.plan'])->find($customer->id);
        $plan = Plan::with(['features', 'prices.currency'])->findOrFail($planId);
        $currentPlan = $customer->getPlan()?->first();

        // Get customer's country for pricing
        $customerCountry = Country::where('code', 'SA')->first();
        if (!$customerCountry) {
            $customerCountry = Country::first();
        }

        $planPrice = $plan->getPriceForCountry($customerCountry->id);

        if (!$planPrice) {
            return redirect()->back()->with('error', 'Plan pricing not available for your region.');
        }

        return view('customer.upgrade-plan', compact(
            'customer',
            'plan',
            'currentPlan',
            'planPrice',
            'customerCountry'
        ));
    }

    public function cancel(Request $request)
    {
        $locale = app()->getLocale();
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();
        $currentSubscription = $customer->currentSubscription();

        if (!$currentSubscription) {
            return redirect()->back()->with('error', 'No active subscription to cancel.');
        }

        try {
            // Set subscription to end at the current billing period
            $currentSubscription->update([
                'grace_date' => $currentSubscription->end_date->copy()->addDays(7)
            ]);

            return redirect()->route('customer.subscription.index', ['locale' => $locale])
                ->with('warning', 'Subscription cancellation requested. Your subscription will remain active until ' . $currentSubscription->end_date->format('M d, Y') . '.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to cancel subscription. Please contact support.');
        }
    }

    public function invoice(Request $request, $invoiceId)
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();
        $invoice = Invoice::where('customer_id', $customer->id)
            ->with(['plan'])
            ->findOrFail($invoiceId);

        return view('customer.invoice', compact('invoice', 'customer'));
    }
}
