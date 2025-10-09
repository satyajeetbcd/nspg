<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::guard('customer')->check()) {
            $customerId = Auth::guard('customer')->id();
            $customer = $customerId ? Customer::with(['companies', 'invoices', 'subscriptions.plan.features', 'subscriptions.plan.prices.currency'])->find($customerId) : null;
            $company = $customer?->primaryCompany;

            // Get current subscription and plan
            $currentSubscription = $customer?->currentSubscription();
            $currentPlan = $customer?->getPlan()?->first();

            // Get plan features and modules
            $modules = $this->getPlanModules($currentPlan);
            $progress = $this->calculatePlanProgress($currentPlan, $customer);

            return view('customer.dashboard', compact(
                'customer',
                'company',
                'currentSubscription',
                'currentPlan',
                'modules',
                'progress'
            ));
        }

        return redirect()->route('public.login');
    }

    public function home()
    {
        $customer = Auth::guard('customer')->user();
        $customer = Customer::with(['companies'])->find($customer->id);
        $company = $customer->primaryCompany;
        return view('customer.plan', compact('customer', 'company'));
    }

    public function getStats()
    {
        $customer = Auth::guard('customer')->user();
        $customer = Customer::with(['invoices', 'subscriptions.plan'])->find($customer->id);

        return response()->json([
            'invoices_count' => $customer->invoices->count(),
            'paid_invoices' => $customer->invoices->where('status', 'paid')->count(),
            'pending_invoices' => $customer->invoices->where('status', 'pending')->count(),
            'plan_status' => $customer->getPlan()?->first() ? 'active' : 'no_plan',
            'plan_name' => $customer->getPlan()?->first()?->name ?? 'Free Plan',
        ]);
    }

    public function getPlanTimeInfo()
    {
        $customer = Auth::guard('customer')->user();
        $subscription = $customer->currentSubscription();

        if (!$subscription) {
            return response()->json([
                'has_plan' => false,
                'message' => 'No active subscription'
            ]);
        }

        return response()->json([
            'has_plan' => true,
            'plan_name' => $subscription->plan->name,
            'end_date' => $subscription->end_date?->format('Y-m-d'),
            'days_remaining' => $subscription->days_remaining,
            'is_active' => $subscription->isActive(),
            'status' => $subscription->status,
        ]);
    }

    /**
     * Get plan modules based on current plan
     */
    private function getPlanModules($currentPlan)
    {
        // Default modules for no plan
        $defaultModules = [
            'CRM' => [
                'value' => false,
                'tooltip' => 'Manage customer relationships',
            ],
            'Account' => [
                'value' => false,
                'tooltip' => 'Accounting & finance',
            ],
            'HRM' => [
                'value' => false,
                'tooltip' => 'Manage employees & payroll',
            ],
            'Project' => [
                'value' => false,
                'tooltip' => 'Project management tools',
            ],
            'POS' => [
                'value' => false,
                'tooltip' => 'Point of Sale system',
            ],
            'Storage Limit' => [
                'value' => 0,
                'tooltip' => 'Max storage in GB',
            ],
        ];

        if (!$currentPlan || !$currentPlan->features()->exists()) {
            return $defaultModules;
        }

        $planFeatures = $currentPlan->features()->first();
        if (!$planFeatures) {
            return $defaultModules;
        }

        // Map plan features to modules
        return [
            'CRM' => [
                'value' => (bool) $planFeatures->module_crm,
                'tooltip' => 'Manage customer relationships',
            ],
            'Account' => [
                'value' => (bool) $planFeatures->module_account,
                'tooltip' => 'Accounting & finance',
            ],
            'HRM' => [
                'value' => (bool) $planFeatures->module_hrm,
                'tooltip' => 'Manage employees & payroll',
            ],
            'Project' => [
                'value' => (bool) $planFeatures->module_project,
                'tooltip' => 'Project management tools',
            ],
            'POS' => [
                'value' => (bool) $planFeatures->module_pos,
                'tooltip' => 'Point of Sale system',
            ],
            'Storage Limit' => [
                'value' => $this->getStorageLimit($planFeatures),
                'tooltip' => 'Max storage in GB',
            ],
        ];
    }

    /**
     * Calculate plan progress percentage
     */
    private function calculatePlanProgress($currentPlan, $customer)
    {
        if (!$currentPlan) {
            return 0;
        }

        // Calculate based on active features vs total available features
        $modules = $this->getPlanModules($currentPlan);
        $activeFeatures = 0;
        $totalFeatures = 0;

        foreach ($modules as $module) {
            if (is_bool($module['value'])) {
                $totalFeatures++;
                if ($module['value']) {
                    $activeFeatures++;
                }
            }
        }

        return $totalFeatures > 0 ? round(($activeFeatures / $totalFeatures) * 100) : 0;
    }

    /**
     * Get storage limit from plan features
     */
    private function getStorageLimit($planFeatures)
    {
        // Parse storage from more_features JSON if available
        if ($planFeatures->more_featrues) {
            $features = $planFeatures->more_featrues;
            if (is_array($features)) {
                foreach ($features as $feature) {
                    if (strpos($feature, 'GB') !== false || strpos($feature, 'Storage') !== false) {
                        // Extract number from string like "1GB Storage" or "10GB"
                        preg_match('/(\d+)/', $feature, $matches);
                        if (isset($matches[1])) {
                            return (int) $matches[1];
                        }
                    }
                }
            }
        }

        // Default storage limits based on plan type
        return 0; // No plan = no storage
    }
}
