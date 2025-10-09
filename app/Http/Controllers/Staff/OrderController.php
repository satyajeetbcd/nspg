<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Plan;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController  
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'plan', 'currency'])
            ->latest()
            ->paginate(15);
            
        return view('staff.orders.index', compact('orders'));
    }

    /**
     * Display pending orders that need staff approval.
     */
    public function pending()
    {
        $orders = Order::with(['customer', 'plan', 'currency'])
            ->pending()
            ->latest()
            ->paginate(15);
            
        return view('staff.orders.pending', compact('orders'));
    }

    /**
     * Display paid orders.
     */
    public function paid()
    {
        $orders = Order::with(['customer', 'plan', 'currency'])
            ->paid()
            ->latest()
            ->paginate(15);
            
        return view('staff.orders.paid', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($locale, Order $order)
    {
        $order->load(['customer', 'plan', 'previousPlan', 'currency', 'invoice', 'subscription']);
        return view('staff.orders.show', compact('order'));
    }

    /**
     * Accept a pending order and create subscription.
     */
    public function accept(Request $request, $locale, Order $order)
    {
        $request->validate([
            'payment_type' => 'required|string|in:cash,bank_transfer,check,other',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Accept the order
            $invoice = $order->acceptByStaff(
                $request->payment_type,
                $request->notes
            );

            DB::commit();

            return redirect()->route('staff.orders.show', ['locale' => $locale, 'order' => $order])
                ->with('success', 'Order accepted successfully! Customer has been registered to subscription and invoice generated.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Failed to accept order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Reject/cancel an order.
     */
    public function reject(Request $request, $locale, Order $order)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        try {
            $order->update([
                'payment_status' => Order::STATUS_CANCELLED,
                'notes' => trim(($order->notes ?? '') . "\nRejected by staff: " . $request->reason),
            ]);

            return redirect()->route('staff.orders.show', ['locale' => $locale, 'order' => $order])
                ->with('success', 'Order has been rejected.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject order: ' . $e->getMessage());
        }
    }

    /**
     * Mark order as paid manually.
     */
    public function markPaid(Request $request, $locale, Order $order)
    {
        $request->validate([
            'transaction_id' => 'nullable|string|max:255',
            'payment_type' => 'required|string|in:card,bank_transfer,paypal,other',
        ]);

        try {
            DB::beginTransaction();

            // Mark as paid
            $order->markAsPaid(
                $request->transaction_id,
                $request->payment_type
            );

            // Process order to create subscription and invoice
            $this->orderService->processOrderToSubscription($order);
            $invoice = $this->orderService->generateInvoiceFromOrder($order);

            DB::commit();

            return redirect()->route('staff.orders.show', ['locale' => $locale, 'order' => $order])
                ->with('success', 'Order marked as paid successfully! Subscription created and invoice generated.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Failed to mark order as paid: ' . $e->getMessage());
        }
    }

    /**
     * Get order statistics for dashboard.
     */
    public function getStats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'paid_orders' => Order::paid()->count(),
            'cancelled_orders' => Order::where('payment_status', Order::STATUS_CANCELLED)->count(),
            'total_revenue' => Order::paid()->sum('price'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())->paid()->sum('price'),
        ];

        return response()->json($stats);
    }

    /**
     * Export orders to CSV.
     */
    public function export(Request $request)
    {
        $query = Order::with(['customer', 'plan', 'currency']);

        // Apply filters
        if ($request->status) {
            if ($request->status === 'pending') {
                $query->pending();
            } elseif ($request->status === 'paid') {
                $query->paid();
            } else {
                $query->where('payment_status', $request->status);
            }
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->get();

        $filename = 'orders_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Order ID',
                'Customer Name',
                'Customer Email',
                'Plan Name',
                'Order Type',
                'Amount',
                'Currency',
                'Payment Status',
                'Payment Type',
                'Created Date',
                'Paid Date'
            ]);

            // CSV data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_id,
                    $order->customer->name ?? 'N/A',
                    $order->customer->email ?? 'N/A',
                    $order->plan->name ?? 'N/A',
                    $order->order_type_display,
                    $order->price,
                    $order->currency->currency_name ?? 'USD',
                    $order->payment_status_display,
                    $order->payment_type ?? 'N/A',
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->paid_at ? $order->paid_at->format('Y-m-d H:i:s') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}