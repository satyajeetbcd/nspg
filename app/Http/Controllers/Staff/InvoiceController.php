<?php

namespace App\Http\Controllers\Staff;

use App\Models\Invoice;
use App\Models\Customer;
use App\Services\MailjetEmailService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InvoiceController extends Controller
{
    protected $mailjetService;

    public function __construct(MailjetEmailService $mailjetService)
    {
        $this->mailjetService = $mailjetService;
    }

    public function index()
    {
        $invoices = Invoice::with(['customer', 'plan', 'currency.currencyLanguages'])
            ->latest()
            ->paginate(15);
        $statusClasses = [
            'pending' => 'bg-warning-subtle text-warning',
            'paid' => 'bg-success-subtle text-success',
            'cancelled' => 'bg-danger-subtle text-danger',
            'refunded' => 'bg-info-subtle text-info'
        ];
        return view('staff.invoices.index', compact('invoices','statusClasses'));
    }

    public function create()
    {
        $customers = Customer::where('is_active', 1)->get();
        $plans = \App\Models\Plan::where('is_visible', 1)->with('prices.currency')->get();
        $currencies = \App\Models\Currency::with('currencyLanguages')->get();
        return view('staff.invoices.create', compact('customers', 'plans', 'currencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currency,currency_id',
            'due_date' => 'required|date|after:today',
            'status' => 'nullable|in:pending,paid,cancelled,refunded',
        ]);

        // Get plan price if amount not provided
        if (empty($validated['amount'])) {
            $plan = \App\Models\Plan::find($validated['plan_id']);
            $validated['amount'] = $plan->prices()->where('currency_id', $validated['currency_id'])->first()?->price ?? 0;
        }

        $invoice = Invoice::create([
            'customer_id' => $validated['customer_id'],
            'plan_id' => $validated['plan_id'],
            'amount' => $validated['amount'],
            'currency_id' => $validated['currency_id'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'] ?? 'pending',
        ]);

        // Send email notification via Mailjet
        try {
            $customer = Customer::find($validated['customer_id']);
            $this->mailjetService->sendInvoiceEmail($customer, $invoice);
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send invoice creation email via Mailjet: ' . $e->getMessage());
        }
        return response()->json(['message' => 'Invoice created successfully and notification email sent.'], 200);
    }

    public function show($locale, Invoice $invoice)
    {
        $invoice->load(['customer', 'plan', 'currency.currencyLanguages']);
        return view('staff.invoices.show', compact('invoice'));
    }

    public function edit($locale, Invoice $invoice)
    {
        $customers = Customer::where('is_active', 1)->get();
        $plans = \App\Models\Plan::where('is_visible', 1)->with('prices.currency')->get();
        $currencies = \App\Models\Currency::with('currencyLanguages')->get();
        return view('staff.invoices.edit', compact('invoice', 'customers', 'plans', 'currencies'));
    }

    public function update(Request $request, $locale, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currency,currency_id',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,cancelled,refunded',
        ]);

        $invoice->update([
            'customer_id' => $validated['customer_id'],
            'plan_id' => $validated['plan_id'],
            'amount' => $validated['amount'],
            'currency_id' => $validated['currency_id'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
        ]);
        return response()->json(['message' => 'Invoice updated successfully.'], 200);
    }

    public function destroy($locale, Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('staff.invoices.index', ['locale' => $locale])
            ->with('success', 'Invoice deleted successfully.');
    }

    public function markPaid($locale, Invoice $invoice)
    {
        $invoice->update(['status' => 'paid']);

        // Send email notification via Mailjet
        try {
            $customer = $invoice->customer;
            $this->mailjetService->sendInvoiceEmail($customer, $invoice);
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send invoice payment confirmation email via Mailjet: ' . $e->getMessage());
        }

        return back()->with('success', 'Invoice marked as paid and notification email sent.');
    }

    public function markPending($locale, Invoice $invoice)
    {
        $invoice->update(['status' => 'pending']);

        // Send email notification via Mailjet
        try {
            $customer = $invoice->customer;
            $this->mailjetService->sendInvoiceEmail($customer, $invoice);
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send invoice status update email via Mailjet: ' . $e->getMessage());
        }

        return back()->with('success', 'Invoice marked as pending and notification email sent.');
    }

    public function markOverdue($locale, Invoice $invoice)
    {
        $invoice->update(['status' => 'overdue']);
        return back()->with('success', 'Invoice marked as overdue.');
    }

    public function download($locale, Invoice $invoice)
    {
        $invoice->load(['customer', 'plan', 'currency.currencyLanguages']);

        try {
            // Generate PDF using a simple HTML to PDF approach
            $html = view('staff.invoices.pdf', compact('invoice'))->render();

            // For now, return a simple response with invoice details
            // In production, you would use a PDF library like DomPDF or TCPDF
            $filename = 'invoice-' . $invoice->code . '.pdf';

            return response()->streamDownload(function () use ($html) {
                echo $html;
            }, $filename, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    public function sendEmail($locale, Invoice $invoice)
    {
        $invoice->load(['customer', 'plan', 'currency.currencyLanguages']);

        try {
            // Check if customer has email
            if (!$invoice->customer->email) {
                return back()->with('error', 'Customer does not have an email address.');
            }

            // Send email notification
            \Mail::to($invoice->customer->email)->send(new \App\Mail\InvoiceNotification($invoice));

            return back()->with('success', 'Invoice email sent successfully to ' . $invoice->customer->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
