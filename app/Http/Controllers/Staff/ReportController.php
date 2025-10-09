<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportController extends Controller
{
    public function index()
    {
        return view('staff.reports.index');
    }

    public function customers()
    {
        return view('staff.reports.customers');
    }

    public function revenue()
    {
        return view('staff.reports.revenue');
    }

    public function plans()
    {
        return view('staff.reports.plans');
    }

    public function invoices()
    {
        return view('staff.reports.invoices');
    }

    public function analytics()
    {
        return view('staff.reports.analytics');
    }

    public function export($locale, $type)
    {
        // TODO: Implement export functionality
        return back()->with('info', "Export for {$type} will be implemented soon.");
    }
}


