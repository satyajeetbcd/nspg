<?php

namespace App\Http\Middleware\Role;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionAccess
{
    /**
     * Handle an incoming request to check subscription access.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $feature  Optional feature to check
     */
    public function handle(Request $request, Closure $next, string $feature = null): Response
    {
        // Check if customer is authenticated
        if (!Auth::guard('customer')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $customer = Auth::guard('customer')->user();

        // Check if customer has an active subscription
        if (!$this->hasActiveSubscription($customer)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Active subscription required.',
                    'redirect' => route('customer.plan-requests.index')
                ], 403);
            }

            return redirect()->route('customer.plan-requests.index')
                ->with('warning', 'Please subscribe to a plan to access this feature.');
        }

        // Check specific feature access if provided
        if ($feature && !$this->hasFeatureAccess($customer, $feature)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Feature not available in your current plan.',
                    'redirect' => route('customer.subscription.upgrade')
                ], 403);
            }

            return redirect()->route('customer.subscription.upgrade')
                ->with('info', "Please upgrade your plan to access the '{$feature}' feature.");
        }

        return $next($request);
    }

    /**
     * Check if customer has an active subscription.
     *
     * @param mixed $customer
     * @return bool
     */
    private function hasActiveSubscription($customer): bool
    {
        // Check if customer has a plan assigned
        if (empty($customer->plan)) {
            return false;
        }

        // Check if plan is still active (not expired)
        if (isset($customer->plan_expire_date)) {
            return $customer->plan_expire_date && $customer->plan_expire_date->isFuture();
        }

        // If no expiration date is set, consider it active if plan exists
        return true;
    }

    /**
     * Check if customer has access to specific feature.
     *
     * @param mixed $customer
     * @param string $feature
     * @return bool
     */
    private function hasFeatureAccess($customer, string $feature): bool
    {
        // Get customer's current plan
        $currentPlan = $customer->currentPlan();

        if (!$currentPlan) {
            return false;
        }

        // Check if plan has the required feature
        $planFeatures = $currentPlan->features ?? collect();

        // If using plan features relationship
        if (method_exists($currentPlan, 'features')) {
            return $currentPlan->features()
                ->where('feature_name', $feature)
                ->where('is_enabled', true)
                ->exists();
        }

        // If using a simple features array/json
        if (is_array($planFeatures) || is_object($planFeatures)) {
            return in_array($feature, (array) $planFeatures);
        }

        // Default to allowing access if feature checking is not implemented
        return true;
    }
}
