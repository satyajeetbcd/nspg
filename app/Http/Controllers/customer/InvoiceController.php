<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $customerId = Auth::guard('customer')->id();
        $customer = $customerId ? Customer::with(['companies', 'invoices.currency', 'invoices.plan'])->find($customerId) : null;
        $company = $customer?->primaryCompany;

        return view('customer.invoice-list', compact('customer', 'company'));
    }

    public function history()
    {
        $customerId = Auth::guard('customer')->id();
        $customer = $customerId ? Customer::with(['companies', 'invoices.currency', 'invoices.plan'])->find($customerId) : null;
        $company = $customer?->primaryCompany;

        return view('customer.invoice_history', compact('customer', 'company'));
    }

    public function show($locale, $invoice)
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        // Find the invoice and ensure customer can only view their own invoices
        $invoice = $customer->invoices()
                           ->where('id', $invoice)
                           ->with(['subscription.plan', 'company', 'currency'])
                           ->firstOrFail();

        return view('customer.invoice-details', compact('invoice'));
    }

    public function download($locale, $invoice)
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        // Find the invoice and ensure customer can only download their own invoices
        $invoice = $customer->invoices()
                           ->where('id', $invoice)
                           ->firstOrFail();

        // TODO: Implement PDF generation and download
        return response()->json(['message' => 'Invoice download feature coming soon'], 501);
    }

    public function pay($locale, $invoice)
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        // Find the invoice and ensure customer can only pay their own invoices
        $invoice = $customer->invoices()
                           ->where('id', $invoice)
                           ->where('status', 'pending')
                           ->firstOrFail();

        // TODO: Implement payment processing
        return response()->json(['message' => 'Payment processing feature coming soon'], 501);
    }
}
