<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ReportService
{
    /**
     * Get overview statistics
     */
    public function getOverviewStats()
    {
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('is_active', true)->count();
        $totalRevenue = Invoice::where('status', 'paid')->sum('amount');
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $pendingInvoices = Invoice::where('status', 'pending')->count();
        $overdueInvoices = Invoice::where('status', 'overdue')->count();
        $totalPlans = Plan::where('is_visible', true)->count();
        try {
            $activeSubscriptions = Subscription::where('end_date', '>', now())->count();
        } catch (\Exception $e) {
            Log::warning('Subscriptions table not found, using fallback: ' . $e->getMessage());
            $activeSubscriptions = 0;
        }

        return [
            'customers' => [
                'total' => $totalCustomers,
                'active' => $activeCustomers,
                'inactive' => $totalCustomers - $activeCustomers,
                'growth_rate' => $this->calculateGrowthRate('customers'),
            ],
            'revenue' => [
                'total' => $totalRevenue,
                'monthly' => $this->getMonthlyRevenueTotal(),
                'growth_rate' => $this->calculateGrowthRate('revenue'),
            ],
            'invoices' => [
                'total' => $totalInvoices,
                'paid' => $paidInvoices,
                'pending' => $pendingInvoices,
                'overdue' => $overdueInvoices,
                'paid_rate' => $totalInvoices > 0 ? round(($paidInvoices / $totalInvoices) * 100, 2) : 0,
            ],
            'plans' => [
                'total' => $totalPlans,
                'active_subscriptions' => $activeSubscriptions,
            ],
        ];
    }

    /**
     * Get recent activities
     */
    public function getRecentActivities()
    {
        $recentCustomers = Customer::latest()->take(5)->get();
        $recentInvoices = Invoice::with('customer')->latest()->take(5)->get();
        try {
            $recentSubscriptions = Subscription::with(['customer', 'plan'])->latest()->take(5)->get();
        } catch (\Exception $e) {
            Log::warning('Subscriptions table not found, using empty collection: ' . $e->getMessage());
            $recentSubscriptions = collect();
        }

        return [
            'customers' => $recentCustomers,
            'invoices' => $recentInvoices,
            'subscriptions' => $recentSubscriptions,
        ];
    }

    /**
     * Get monthly revenue data
     */
    public function getMonthlyRevenue()
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Invoice::where('status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');

            $months[] = [
                'month' => $date->format('M Y'),
                'revenue' => $revenue,
            ];
        }

        return $months;
    }

    /**
     * Get plan distribution
     */
    public function getPlanDistribution()
    {
        return Customer::select('plan', DB::raw('count(*) as count'))
            ->join('plans', 'customers.plan', '=', 'plans.id')
            ->where('plans.is_visible', true)
            ->groupBy('plan', 'plans.id')
            ->get()
            ->map(function ($item) {
                return [
                    'plan_name' => $item->id ?? 'No Plan',
                    'count' => $item->count,
                ];
            });
    }

    /**
     * Get customer statistics
     */
    public function getCustomerStats($filters = [])
    {
        $query = Customer::query();
        $this->applyDateFilters($query, $filters);

        $total = $query->count();
        $active = $query->where('is_active', true)->count();
        $verified = $query->whereNotNull('email_verified_at')->count();

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $total - $active,
            'verified' => $verified,
            'unverified' => $total - $verified,
        ];
    }

    /**
     * Get customer growth data
     */
    public function getCustomerGrowth($filters = [])
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $query = Customer::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);

            $this->applyDateFilters($query, $filters);

            $months[] = [
                'month' => $date->format('M Y'),
                'count' => $query->count(),
            ];
        }

        return $months;
    }

    /**
     * Get customers by plan
     */
    public function getCustomersByPlan($filters = [])
    {
        $query = Customer::select('plan', DB::raw('count(*) as count'))
            ->join('plans', 'customers.plan', '=', 'plans.id')
            ->where('plans.is_visible', true)
            ->groupBy('plan', 'plans.id');

        $this->applyDateFilters($query, $filters);

        if (isset($filters['plan_id'])) {
            $query->where('customers.plan', $filters['plan_id']);
        }

        return $query->get()->map(function ($item) {
            return [
                'plan_name' => $item->id ?? 'No Plan',
                'count' => $item->count,
            ];
        });
    }

    /**
     * Get customers by country
     */
    public function getCustomersByCountry($filters = [])
    {
        try {
            $query = Customer::select('country', DB::raw('count(*) as count'))
                ->groupBy('country');

            $this->applyDateFilters($query, $filters);

            return $query->get()->map(function ($item) {
                return [
                    'country' => $item->country ?? 'Unknown',
                    'count' => $item->count,
                ];
            });
        } catch (\Exception $e) {
            Log::warning('Country column not found, using fallback data: ' . $e->getMessage());

            // Fallback: return customers grouped by a default value
            $query = Customer::select(DB::raw('count(*) as count'));
            $this->applyDateFilters($query, $filters);
            $totalCustomers = $query->count();

            return collect([
                [
                    'country' => 'Unknown',
                    'count' => $totalCustomers,
                ]
            ]);
        }
    }

    /**
     * Get top customers by revenue
     */
    public function getTopCustomers($filters = [])
    {
        $query = Customer::select('customers.*', DB::raw('SUM(invoices.amount) as total_revenue'))
            ->leftJoin('invoices', 'customers.id', '=', 'invoices.customer_id')
            ->where('invoices.status', 'paid')
            ->groupBy('customers.id')
            ->orderBy('total_revenue', 'desc')
            ->take(10);

        $this->applyDateFilters($query, $filters);

        return $query->get();
    }

    /**
     * Get revenue statistics
     */
    public function getRevenueStats($filters = [])
    {
        $query = Invoice::where('status', 'paid');
        $this->applyDateFilters($query, $filters);

        $total = $query->sum('amount');
        $count = $query->count();
        $average = $count > 0 ? $total / $count : 0;

        return [
            'total' => $total,
            'count' => $count,
            'average' => $average,
            'growth_rate' => $this->calculateGrowthRate('revenue', $filters),
        ];
    }

    /**
     * Get revenue by month
     */
    public function getRevenueByMonth($filters = [])
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $query = Invoice::where('status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);

            $this->applyDateFilters($query, $filters);

            $months[] = [
                'month' => $date->format('M Y'),
                'revenue' => $query->sum('amount'),
            ];
        }

        return $months;
    }

    /**
     * Get revenue by plan
     */
    public function getRevenueByPlan($filters = [])
    {
        $query = Invoice::select('plans.id', DB::raw('SUM(invoices.amount) as revenue'))
            ->join('plans', 'invoices.plan_id', '=', 'plans.id')
            ->where('invoices.status', 'paid')
            ->where('plans.is_visible', true)
            ->groupBy('plans.id'); // remove duplicate

        // Apply date filters (make sure applyDateFilters prefixes the table!)
        $this->applyDateFilters($query, $filters);

        // Filter by plan_id if provided
        if (isset($filters['plan_id'])) {
            $query->where('invoices.plan_id', $filters['plan_id']);
        }

        return $query->get();
    }

    /**
     * Get revenue by country
     */
    public function getRevenueByCountry($filters = [])
    {
        try {
            $query = Invoice::select('customers.country', DB::raw('SUM(invoices.amount) as revenue'))
                ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                ->where('invoices.status', 'paid')
                ->groupBy('customers.country');

            $this->applyDateFilters($query, $filters);

            return $query->get();
        } catch (\Exception $e) {
            Log::warning('Country column not found in revenue query, using fallback: ' . $e->getMessage());

            // Fallback: return total revenue without country breakdown
            $query = Invoice::select(DB::raw('SUM(invoices.amount) as revenue'))
                ->where('invoices.status', 'paid');
            $this->applyDateFilters($query, $filters);
            $totalRevenue = $query->first()->revenue ?? 0;

            return collect([
                (object) [
                    'country' => 'Unknown',
                    'revenue' => $totalRevenue,
                ]
            ]);
        }
    }

    /**
     * Get payment methods data
     */
    public function getPaymentMethods($filters = [])
    {
        // This would need to be implemented based on your payment system
        return [
            ['method' => 'Credit Card', 'count' => 0, 'amount' => 0],
            ['method' => 'Bank Transfer', 'count' => 0, 'amount' => 0],
            ['method' => 'PayPal', 'count' => 0, 'amount' => 0],
        ];
    }

    /**
     * Get recurring vs one-time revenue
     */
    public function getRecurringVsOneTime($filters = [])
    {
        $query = Invoice::where('status', 'paid');
        $this->applyDateFilters($query, $filters);

        // This would need to be implemented based on your subscription system
        return [
            'recurring' => $query->sum('amount') * 0.7, // Placeholder
            'one_time' => $query->sum('amount') * 0.3, // Placeholder
        ];
    }

    /**
     * Get plan statistics
     */
    public function getPlanStats($filters = [])
    {
        $query = Plan::where('is_visible', true);

        if (isset($filters['plan_id'])) {
            $query->where('id', $filters['plan_id']);
        }

        $plans = $query->get();
        try {
            $totalSubscriptions = Subscription::count();
        } catch (\Exception $e) {
            Log::warning('Subscriptions table not found, using fallback: ' . $e->getMessage());
            $totalSubscriptions = 0;
        }
        $totalRevenue = Invoice::where('status', 'paid')->sum('amount');

        return [
            'total_plans' => $plans->count(),
            'total_subscriptions' => $totalSubscriptions,
            'total_revenue' => $totalRevenue,
            'average_price' => $plans->avg('price'),
        ];
    }

    /**
     * Get plan performance
     */
    public function getPlanPerformance($filters = [])
    {
        try {
            $query = Plan::select(
                'plans.*',
                DB::raw('COUNT(subscriptions.id) as subscription_count'),
                DB::raw('SUM(invoices.amount) as total_revenue')
            )
                ->leftJoin('subscriptions', 'plans.id', '=', 'subscriptions.plan_id')
                ->leftJoin('invoices', 'plans.id', '=', 'invoices.plan_id')
                ->where('plans.is_visible', true)
                ->groupBy('plans.id');

            $this->applyDateFilters($query, $filters);

            if (isset($filters['plan_id'])) {
                $query->where('plans.id', $filters['plan_id']);
            }

            return $query->get();
        } catch (\Exception $e) {
            // Fallback to basic plan data if subscriptions table doesn't exist
            Log::warning('Subscriptions table not found, using fallback data: ' . $e->getMessage());

            $query = Plan::where('is_visible', true);

            if (isset($filters['plan_id'])) {
                $query->where('id', $filters['plan_id']);
            }

            return $query->get()->map(function ($plan) {
                return (object) [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'price' => $plan->price,
                    'duration' => $plan->duration,
                    'subscription_count' => 0,
                    'total_revenue' => 0,
                ];
            });
        }
    }

    /**
     * Get plan subscriptions
     */
    public function getPlanSubscriptions($filters = [])
    {
        try {
            $query = Subscription::with(['plan', 'customer'])
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->where('plans.is_visible', true);

            $this->applyDateFilters($query, $filters);

            if (isset($filters['plan_id'])) {
                $query->where('subscriptions.plan_id', $filters['plan_id']);
            }

            return $query->latest()->paginate(15);
        } catch (\Exception $e) {
            // Fallback to empty collection if subscriptions table doesn't exist
            Log::warning('Subscriptions table not found, returning empty collection: ' . $e->getMessage());
            return collect()->paginate(15);
        }
    }

    /**
     * Get plan revenue
     */
    public function getPlanRevenue($filters = [])
    {
        $query = Invoice::select(
            'plans.id',
            DB::raw('SUM(invoices.amount) as revenue'),
            DB::raw('COUNT(invoices.id) as invoice_count')
        )
            ->join('plans', 'invoices.plan_id', '=', 'plans.id')
            ->where('invoices.status', 'paid')
            ->where('plans.is_visible', true)
            ->groupBy('plans.id', 'plans.id');

        $this->applyDateFilters($query, $filters);

        if (isset($filters['plan_id'])) {
            $query->where('invoices.plan_id', $filters['plan_id']);
        }

        return $query->get();
    }

    /**
     * Get plan churn data
     */
    public function getPlanChurn($filters = [])
    {
        // This would need to be implemented based on your churn calculation logic
        return [
            'total_churned' => 0,
            'churn_rate' => 0,
            'retention_rate' => 100,
        ];
    }

    /**
     * Get invoice statistics
     */
    public function getInvoiceStats($filters = [])
    {
        $query = Invoice::query();
        $this->applyDateFilters($query, $filters);

        $total = $query->count();
        $paid = $query->where('status', 'paid')->count();
        $pending = $query->where('status', 'pending')->count();
        $overdue = $query->where('status', 'overdue')->count();
        $totalAmount = $query->sum('amount');
        $paidAmount = $query->where('status', 'paid')->sum('amount');

        return [
            'total' => $total,
            'paid' => $paid,
            'pending' => $pending,
            'overdue' => $overdue,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'paid_rate' => $total > 0 ? round(($paid / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Get invoice by status
     */
    public function getInvoiceByStatus($filters = [])
    {
        $query = Invoice::select('status', DB::raw('count(*) as count'))
            ->groupBy('status');

        $this->applyDateFilters($query, $filters);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    /**
     * Get invoice by month
     */
    public function getInvoiceByMonth($filters = [])
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $query = Invoice::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);

            $this->applyDateFilters($query, $filters);

            $months[] = [
                'month' => $date->format('M Y'),
                'count' => $query->count(),
                'amount' => $query->sum('amount'),
            ];
        }

        return $months;
    }

    /**
     * Get overdue invoices
     */
    public function getOverdueInvoices($filters = [])
    {
        $query = Invoice::with(['customer', 'plan'])
            ->where('status', 'overdue')
            ->orWhere(function ($q) {
                $q->where('status', 'pending')
                    ->where('due_date', '<', now());
            });

        $this->applyDateFilters($query, $filters);

        if (isset($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        return $query->latest()->paginate(15);
    }

    /**
     * Get payment trends
     */
    public function getPaymentTrends($filters = [])
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $query = Invoice::where('status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);

            $this->applyDateFilters($query, $filters);

            $months[] = [
                'month' => $date->format('M Y'),
                'paid_count' => $query->count(),
                'paid_amount' => $query->sum('amount'),
            ];
        }

        return $months;
    }

    /**
     * Get analytics data
     */
    public function getAnalytics($filters = [])
    {
        return [
            'conversion_rate' => $this->calculateConversionRate($filters),
            'average_order_value' => $this->calculateAverageOrderValue($filters),
            'customer_lifetime_value' => $this->calculateCustomerLifetimeValue($filters),
            'churn_rate' => $this->calculateChurnRate($filters),
        ];
    }

    /**
     * Get conversion funnel
     */
    public function getConversionFunnel($filters = [])
    {
        // This would need to be implemented based on your funnel logic
        return [
            ['stage' => 'Visitors', 'count' => 1000],
            ['stage' => 'Signups', 'count' => 100],
            ['stage' => 'Trials', 'count' => 50],
            ['stage' => 'Paid', 'count' => 25],
        ];
    }

    /**
     * Get retention analysis
     */
    public function getRetentionAnalysis($filters = [])
    {
        // This would need to be implemented based on your retention logic
        return [
            'month_1' => 85,
            'month_3' => 70,
            'month_6' => 60,
            'month_12' => 50,
        ];
    }

    /**
     * Get lifetime value
     */
    public function getLifetimeValue($filters = [])
    {
        $query = Customer::select('customers.*', DB::raw('SUM(invoices.amount) as total_revenue'))
            ->leftJoin('invoices', 'customers.id', '=', 'invoices.customer_id')
            ->where('invoices.status', 'paid')
            ->groupBy('customers.id');

        $this->applyDateFilters($query, $filters);

        $customers = $query->get();
        $averageLTV = $customers->avg('total_revenue');

        return [
            'average' => $averageLTV,
            'total_customers' => $customers->count(),
            'high_value_customers' => $customers->where('total_revenue', '>', $averageLTV * 2)->count(),
        ];
    }

    /**
     * Get churn analysis
     */
    public function getChurnAnalysis($filters = [])
    {
        // This would need to be implemented based on your churn logic
        return [
            'monthly_churn' => 5.2,
            'quarterly_churn' => 15.1,
            'annual_churn' => 45.3,
            'retention_rate' => 54.7,
        ];
    }

    /**
     * Export report to CSV
     */
    public function exportReport($type, $filters = [])
    {
        $data = $this->getReportData($type, $filters);

        $filename = $type . '_report_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            if (!empty($data)) {
                // Write headers
                fputcsv($file, array_keys($data[0]));

                // Write data
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get report data for export
     */
    public function getReportData($type, $filters = [])
    {
        switch ($type) {
            case 'customers':
                return $this->getCustomerExportData($filters);
            case 'revenue':
                return $this->getRevenueExportData($filters);
            case 'plans':
                return $this->getPlanExportData($filters);
            case 'invoices':
                return $this->getInvoiceExportData($filters);
            default:
                return [];
        }
    }

    /**
     * Apply date filters to query
     */
    public function applyDateFilters($query, $filters)
    {
        if (!empty($filters['start_date'])) {
            $query->where('invoices.created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->where('invoices.created_at', '<=', $filters['end_date']);
        }
    }

    /**
     * Calculate growth rate
     */
    private function calculateGrowthRate($type, $filters = [])
    {
        $currentPeriod = $this->getCurrentPeriodData($type, $filters);
        $previousPeriod = $this->getPreviousPeriodData($type, $filters);

        if ($previousPeriod == 0) {
            return $currentPeriod > 0 ? 100 : 0;
        }

        return round((($currentPeriod - $previousPeriod) / $previousPeriod) * 100, 2);
    }

    /**
     * Get current period data
     */
    private function getCurrentPeriodData($type, $filters)
    {
        $query = $this->getBaseQuery($type);
        $this->applyDateFilters($query, $filters);

        return $query->count();
    }

    /**
     * Get previous period data
     */
    private function getPreviousPeriodData($type, $filters)
    {
        $query = $this->getBaseQuery($type);

        // Apply previous period filters
        if (isset($filters['date_from']) && isset($filters['date_to'])) {
            $periodLength = Carbon::parse($filters['date_to'])->diffInDays(Carbon::parse($filters['date_from']));
            $previousStart = Carbon::parse($filters['date_from'])->subDays($periodLength);
            $previousEnd = Carbon::parse($filters['date_from']);

            $query->whereBetween('created_at', [$previousStart, $previousEnd]);
        } else {
            $query->where('created_at', '>=', Carbon::now()->subMonth())
                ->where('created_at', '<', Carbon::now());
        }

        return $query->count();
    }

    /**
     * Get base query for type
     */
    private function getBaseQuery($type)
    {
        switch ($type) {
            case 'customers':
                return Customer::query();
            case 'revenue':
                return Invoice::where('status', 'paid');
            default:
                return Customer::query();
        }
    }

    /**
     * Get monthly revenue total
     */
    private function getMonthlyRevenueTotal()
    {
        return Invoice::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
    }

    /**
     * Calculate conversion rate
     */
    private function calculateConversionRate($filters)
    {
        // This would need to be implemented based on your conversion logic
        return 2.5;
    }

    /**
     * Calculate average order value
     */
    private function calculateAverageOrderValue($filters)
    {
        $query = Invoice::where('status', 'paid');
        $this->applyDateFilters($query, $filters);

        $totalAmount = $query->sum('amount');
        $totalCount = $query->count();

        return $totalCount > 0 ? $totalAmount / $totalCount : 0;
    }

    /**
     * Calculate customer lifetime value
     */
    private function calculateCustomerLifetimeValue($filters)
    {
        $query = Customer::select(DB::raw('AVG(COALESCE(customer_revenue.total, 0)) as avg_ltv'))
            ->leftJoin(
                DB::raw('(SELECT customer_id, SUM(amount) as total FROM invoices WHERE status = "paid" GROUP BY customer_id) as customer_revenue'),
                'customers.id',
                '=',
                'customer_revenue.customer_id'
            );

        $this->applyDateFilters($query, $filters);

        return $query->first()->avg_ltv ?? 0;
    }

    /**
     * Calculate churn rate
     */
    private function calculateChurnRate($filters)
    {
        // This would need to be implemented based on your churn logic
        return 5.2;
    }

    /**
     * Get customer export data
     */
    private function getCustomerExportData($filters)
    {
        $query = Customer::with('plan');
        $this->applyDateFilters($query, $filters);

        return $query->get()->map(function ($customer) {
            return [
                'ID' => $customer->id,
                'Name' => $customer->name,
                'Email' => $customer->email,
                'Plan' => $customer->plan?->name ?? 'No Plan',
                'Status' => $customer->is_active ? 'Active' : 'Inactive',
                'Created At' => $customer->created_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();
    }

    /**
     * Get revenue export data
     */
    private function getRevenueExportData($filters)
    {
        $query = Invoice::with(['customer', 'plan'])
            ->where('status', 'paid');
        $this->applyDateFilters($query, $filters);

        return $query->get()->map(function ($invoice) {
            return [
                'Invoice ID' => $invoice->id,
                'Customer' => $invoice->customer->name,
                'Plan' => $invoice->plan?->name ?? 'N/A',
                'Amount' => $invoice->amount,
                'Status' => $invoice->status,
                'Created At' => $invoice->created_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();
    }

    /**
     * Get plan export data
     */
    private function getPlanExportData($filters)
    {
        $query = Plan::where('is_visible', true);

        if (isset($filters['plan_id'])) {
            $query->where('id', $filters['plan_id']);
        }

        return $query->get()->map(function ($plan) {
            return [
                'Plan ID' => $plan->id,
                'Name' => $plan->name,
                'Price' => $plan->price,
                'Duration' => $plan->duration,
                'Max Users' => $plan->max_users,
                'Description' => $plan->description,
                'Created At' => $plan->created_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();
    }

    /**
     * Get invoice export data
     */
    private function getInvoiceExportData($filters)
    {
        $query = Invoice::with(['customer', 'plan']);
        $this->applyDateFilters($query, $filters);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        return $query->get()->map(function ($invoice) {
            return [
                'Invoice ID' => $invoice->id,
                'Customer' => $invoice->customer->name,
                'Plan' => $invoice->plan?->name ?? 'N/A',
                'Amount' => $invoice->amount,
                'Status' => $invoice->status,
                'Due Date' => $invoice->due_date?->format('Y-m-d'),
                'Created At' => $invoice->created_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();
    }
}
