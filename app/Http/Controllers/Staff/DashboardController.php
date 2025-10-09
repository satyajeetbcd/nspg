<?php

namespace App\Http\Controllers\Staff;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the staff dashboard.
     */
    public function index()
    {
        $user = Auth::guard('staff')->user();

        // Required variables for layout
        $uiLocale = app()->getLocale();
        $textDir = $uiLocale === 'ar' ? 'rtl' : 'ltr';
        $globalSetting = null; // You can add global settings logic here
        $unreadCount = 0; // You can add notification logic here
        $notifications = collect(); // You can add notification logic here

        // Stats
        try {
            $stats = [
                'customers' => [
                    'total' => Customer::count(),
                    'growth_rate' => $this->calculateGrowthRate(Customer::class),
                ],
                'revenue' => [
                    'total' => Invoice::sum('amount'),
                    'growth_rate' => $this->calculateRevenueGrowth(),
                ],
                'plans' => [
                    'total' => Plan::count(),
                    'active_subscriptions' => Subscription::where('status', 'active')->count(),
                ],
                'invoices' => [
                    'total' => Invoice::count(),
                    'paid_rate' => $this->calculatePaidRate(),
                ],
            ];
        } catch (\Exception $e) {
            $stats = [
                'customers' => ['total' => 0, 'growth_rate' => 0],
                'revenue' => ['total' => 0, 'growth_rate' => 0],
                'plans' => ['total' => 0, 'active_subscriptions' => 0],
                'invoices' => ['total' => 0, 'paid_rate' => 0],
            ];
        }

        // Recent items
        try {
            $recentCustomers = Customer::latest()->take(5)->get();
            $recentInvoices = Invoice::with('customer')->latest()->take(5)->get();
            $recentSubscriptions = Subscription::with('customer', 'plan')->latest()->take(5)->get();
            $plans = Plan::latest()->take(5)->get();
        } catch (\Exception $e) {
            $recentCustomers = collect();
            $recentInvoices = collect();
            $recentSubscriptions = collect();
            $plans = collect();
        }

        // Recent Activities (combined)
        $recentActivities = collect();

        $recentCustomers->each(function ($customer) use ($recentActivities) {
            $recentActivities->push((object)[
                'user' => $customer,
                'description' => __('Customer created'),
                'created_at' => $customer->created_at
            ]);
        });

        $recentInvoices->each(function ($invoice) use ($recentActivities) {
            $recentActivities->push((object)[
                'user' => $invoice->customer,
                'description' => __('Invoice created'),
                'created_at' => $invoice->created_at
            ]);
        });

        $recentSubscriptions->each(function ($subscription) use ($recentActivities) {
            $recentActivities->push((object)[
                'user' => $subscription->customer,
                'description' => __('Subscription started'),
                'created_at' => $subscription->created_at
            ]);
        });

        $recentActivities = $recentActivities->sortByDesc('created_at')->take(10);

        // Chart data
        try {
            $chartData = $this->getMonthlyRevenueData();
        } catch (\Exception $e) {
            $chartData = [
                'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'revenue' => [0, 0, 0, 0, 0, 0]
            ];
        }
        
        // Customer distribution data for charts
        try {
            $customerDistribution = [
                'active' => Customer::where('is_active', 1)->count(),
                'inactive' => Customer::where('is_active', 0)->count(),
                'pending' => Customer::whereNull('is_active')->count()
            ];
        } catch (\Exception $e) {
            $customerDistribution = [
                'active' => 0,
                'inactive' => 0,
                'pending' => 0
            ];
        }

        return view('staff.dashboard.index', compact(
            'user',
            'uiLocale',
            'textDir',
            'globalSetting',
            'unreadCount',
            'notifications',
            'stats',
            'recentCustomers',
            'recentInvoices',
            'recentSubscriptions',
            'plans',
            'chartData',
            'customerDistribution',
            'recentActivities'
        ));
    }


    // Helper methods

    private function calculateGrowthRate($model)
    {
        $currentMonth = $model::whereMonth('created_at', now()->month)->count();
        $previousMonth = $model::whereMonth('created_at', now()->subMonth()->month)->count();

        if ($previousMonth == 0) return 100;

        return round((($currentMonth - $previousMonth) / $previousMonth) * 100, 2);
    }

    private function calculateRevenueGrowth()
    {
        $currentMonth = Invoice::whereMonth('created_at', now()->month)->sum('amount');
        $previousMonth = Invoice::whereMonth('created_at', now()->subMonth()->month)->sum('amount');

        if ($previousMonth == 0) return 100;

        return round((($currentMonth - $previousMonth) / $previousMonth) * 100, 2);
    }

    private function calculatePaidRate()
    {
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();

        if ($totalInvoices == 0) return 0;

        return round(($paidInvoices / $totalInvoices) * 100, 2);
    }

    private function getMonthlyRevenueData()
    {
        // Example: last 6 months revenue
        $months = collect(range(0, 5))->map(function ($i) {
            return now()->subMonths($i)->format('M Y');
        })->reverse();

        $revenue = $months->map(function ($month) {
            $date = \Carbon\Carbon::parse($month);
            return Invoice::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('amount');
        });

        return [
            'months' => $months,
            'revenue' => $revenue,
        ];
    }

    /**
     * Get dashboard statistics.
     */
    private function getDashboardStats()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth();

        return [
            'total_customers' => Customer::count(),
            'active_customers' => Customer::where('is_active', 1)->count(),
            'pending_customers' => Customer::whereNull('is_active')->count(),
            'verified_customers' => Customer::whereNotNull('email_verified_at')->count(),

            'total_invoices' => Invoice::count(),
            'paid_invoices' => Invoice::where('status', 'paid')->count(),
            'pending_invoices' => Invoice::where('status', 'pending')->count(),
            'overdue_invoices' => Invoice::where('status', 'overdue')->count(),

            'total_revenue' => Invoice::where('status', 'paid')->sum('amount'),
            'monthly_revenue' => Invoice::where('status', 'paid')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('amount'),
            'last_month_revenue' => Invoice::where('status', 'paid')
                ->whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year)
                ->sum('amount'),

            'total_plans' => Plan::count(),
            'active_plans' => Plan::where('is_disable', 0)->count(),
            'most_popular_plan' => $this->getMostPopularPlan(),

            'new_customers_today' => Customer::whereDate('created_at', today())->count(),
            'new_customers_this_week' => Customer::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            'new_customers_this_month' => Customer::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),
        ];
    }

    /**
     * Get chart data for dashboard.
     */
    private function getChartData()
    {
        $last30Days = collect(range(0, 29))->map(function ($days) {
            $date = Carbon::now()->subDays($days);
            return [
                'date' => $date->format('M d'),
                'customers' => Customer::whereDate('created_at', $date)->count(),
                'revenue' => Invoice::where('status', 'paid')
                    ->whereDate('created_at', $date)
                    ->sum('amount'),
                'invoices' => Invoice::whereDate('created_at', $date)->count(),
            ];
        })->reverse()->values();

        $monthlyData = collect(range(0, 11))->map(function ($months) {
            $date = Carbon::now()->subMonths($months);
            return [
                'month' => $date->format('M Y'),
                'customers' => Customer::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
                'revenue' => Invoice::where('status', 'paid')
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->sum('amount'),
            ];
        })->reverse()->values();

        return [
            'daily' => $last30Days,
            'monthly' => $monthlyData,
            'plans_distribution' => $this->getPlansDistribution(),
            'customer_status' => $this->getCustomerStatusDistribution(),
        ];
    }

    /**
     * Get the most popular plan.
     */
    private function getMostPopularPlan()
    {
        $popularPlan = Customer::select('plan', DB::raw('count(*) as count'))
            ->whereNotNull('plan')
            ->groupBy('plan')
            ->orderBy('count', 'desc')
            ->first();

        if (!$popularPlan) {
            return null;
        }

        $plan = Plan::find($popularPlan->plan);
        return $plan ? [
            'name' => $plan->name,
            'subscribers' => $popularPlan->count
        ] : null;
    }

    /**
     * Get plans distribution data.
     */
    private function getPlansDistribution()
    {
        return Customer::select('plans.name', DB::raw('count(*) as count'))
            ->join('plans', 'customers.plan', '=', 'plans.id')
            ->whereNotNull('customers.plan')
            ->groupBy('plans.name', 'plans.id')
            ->orderBy('count', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'count' => $item->count
                ];
            });
    }

    /**
     * Get customer status distribution.
     */
    private function getCustomerStatusDistribution()
    {
        return [
            'active' => Customer::where('is_active', 1)->count(),
            'pending' => Customer::whereNull('is_active')->count(),
            'inactive' => Customer::where('is_active', 0)->count(),
            'verified' => Customer::whereNotNull('email_verified_at')->count(),
            'unverified' => Customer::whereNull('email_verified_at')->count(),
        ];
    }

    /**
     * Get system health status.
     */
    public function getSystemHealth()
    {
        return [
            'database' => $this->checkDatabaseHealth(),
            'storage' => $this->checkStorageHealth(),
            'email' => $this->checkEmailHealth(),
            'cache' => $this->checkCacheHealth(),
        ];
    }

    /**
     * Check database health.
     */
    private function checkDatabaseHealth()
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'healthy', 'message' => 'Database connection OK'];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => 'Database connection failed'];
        }
    }

    /**
     * Check storage health.
     */
    private function checkStorageHealth()
    {
        try {
            $freeSpace = disk_free_space(storage_path());
            $totalSpace = disk_total_space(storage_path());
            $usedPercentage = (($totalSpace - $freeSpace) / $totalSpace) * 100;

            $status = $usedPercentage > 90 ? 'warning' : ($usedPercentage > 95 ? 'unhealthy' : 'healthy');

            return [
                'status' => $status,
                'message' => 'Storage usage: ' . round($usedPercentage, 1) . '%',
                'free_space' => $this->formatBytes($freeSpace),
                'total_space' => $this->formatBytes($totalSpace),
            ];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => 'Storage check failed'];
        }
    }

    /**
     * Check email health.
     */
    private function checkEmailHealth()
    {
        try {
            $configured = !empty(env('MAILJET_API_KEY')) && !empty(env('MAILJET_SECRET_KEY'));
            return [
                'status' => $configured ? 'healthy' : 'warning',
                'message' => $configured ? 'Email service configured' : 'Email service not configured'
            ];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => 'Email check failed'];
        }
    }

    /**
     * Check cache health.
     */
    private function checkCacheHealth()
    {
        try {
            cache()->put('health_check', 'OK', 60);
            $value = cache()->get('health_check');
            return [
                'status' => $value === 'OK' ? 'healthy' : 'unhealthy',
                'message' => $value === 'OK' ? 'Cache working properly' : 'Cache not working'
            ];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => 'Cache check failed'];
        }
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
