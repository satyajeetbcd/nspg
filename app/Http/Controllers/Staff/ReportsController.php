<?php

namespace App\Http\Controllers\Staff;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Order;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Overview Dashboard
     */
    public function overview($locale)
    {
        $stats = $this->reportService->getOverviewStats();
        $recentActivities = $this->reportService->getRecentActivities();
        $monthlyRevenue = $this->reportService->getMonthlyRevenue();
        $planDistribution = $this->reportService->getPlanDistribution();
        
        return view('staff.reports.overview', compact(
            'stats', 
            'recentActivities', 
            'monthlyRevenue', 
            'planDistribution'
        ));
    }

    /**
     * Customer Reports
     */
    public function customers($locale, Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'status', 'plan_id']);
        $customerStats = $this->reportService->getCustomerStats($filters);
        $customerGrowth = $this->reportService->getCustomerGrowth($filters);
        $customerByPlan = $this->reportService->getCustomersByPlan($filters);
        $customerByCountry = $this->reportService->getCustomersByCountry($filters);
        $topCustomers = $this->reportService->getTopCustomers($filters);
        
        $plans = Plan::where('is_visible', true)->get();
        
        return view('staff.reports.customers', compact(
            'customerStats',
            'customerGrowth',
            'customerByPlan',
            'customerByCountry',
            'topCustomers',
            'plans',
            'filters'
        ));
    }

    /**
     * Revenue Reports
     */
    public function revenue($locale, Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'plan_id', 'currency_id']);
        $revenueStats = $this->reportService->getRevenueStats($filters);
        $revenueByMonth = $this->reportService->getRevenueByMonth($filters);
        $revenueByPlan = $this->reportService->getRevenueByPlan($filters);
        $revenueByCountry = $this->reportService->getRevenueByCountry($filters);
        $paymentMethods = $this->reportService->getPaymentMethods($filters);
        $recurringVsOneTime = $this->reportService->getRecurringVsOneTime($filters);
        
        $plans = Plan::where('is_visible', true)->get();
        $currencies = DB::table('currency')->get();
        
        return view('staff.reports.revenue', compact(
            'revenueStats',
            'revenueByMonth',
            'revenueByPlan',
            'revenueByCountry',
            'paymentMethods',
            'recurringVsOneTime',
            'plans',
            'currencies',
            'filters'
        ));
    }

    /**
     * Plan Reports
     */
    public function plans($locale, Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'plan_id']);
        $planStats = $this->reportService->getPlanStats($filters);
        $planPerformance = $this->reportService->getPlanPerformance($filters);
        $planSubscriptions = $this->reportService->getPlanSubscriptions($filters);
        $planRevenue = $this->reportService->getPlanRevenue($filters);
        $planChurn = $this->reportService->getPlanChurn($filters);
        
        $plans = Plan::where('is_visible', true)->get();
        
        return view('staff.reports.plans', compact(
            'planStats',
            'planPerformance',
            'planSubscriptions',
            'planRevenue',
            'planChurn',
            'plans',
            'filters'
        ));
    }

    /**
     * Invoice Reports
     */
    public function invoices($locale, Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'status', 'customer_id']);
        $invoiceStats = $this->reportService->getInvoiceStats($filters);
        $invoiceByStatus = $this->reportService->getInvoiceByStatus($filters);
        $invoiceByMonth = $this->reportService->getInvoiceByMonth($filters);
        $overdueInvoices = $this->reportService->getOverdueInvoices($filters);
        $paymentTrends = $this->reportService->getPaymentTrends($filters);
        
        $customers = Customer::select('id', 'name', 'email')->get();
        
        return view('staff.reports.invoices', compact(
            'invoiceStats',
            'invoiceByStatus',
            'invoiceByMonth',
            'overdueInvoices',
            'paymentTrends',
            'customers',
            'filters'
        ));
    }

    /**
     * Analytics Dashboard
     */
    public function analytics($locale, Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'metric']);
        $analytics = $this->reportService->getAnalytics($filters);
        $conversionFunnel = $this->reportService->getConversionFunnel($filters);
        $retentionAnalysis = $this->reportService->getRetentionAnalysis($filters);
        $lifetimeValue = $this->reportService->getLifetimeValue($filters);
        $churnAnalysis = $this->reportService->getChurnAnalysis($filters);
        
        return view('staff.reports.analytics', compact(
            'analytics',
            'conversionFunnel',
            'retentionAnalysis',
            'lifetimeValue',
            'churnAnalysis',
            'filters'
        ));
    }

    /**
     * Export reports to CSV
     */
    public function export($locale, Request $request)
    {
        $type = $request->get('type');
        $filters = $request->only(['date_from', 'date_to', 'plan_id', 'status', 'customer_id']);
        
        return $this->reportService->exportReport($type, $filters);
    }

    /**
     * Get report data via AJAX
     */
    public function getData($locale, Request $request)
    {
        $type = $request->get('type');
        $filters = $request->only(['date_from', 'date_to', 'plan_id', 'status', 'customer_id']);
        
        $data = $this->reportService->getReportData($type, $filters);
        
        return response()->json($data);
    }
}
