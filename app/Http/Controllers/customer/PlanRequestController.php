<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Country;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlanRequestController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    /**
     * Show available plans for upgrade/new subscription
     */
    public function index()
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();
        $customer = Customer::with(['subscriptions.plan'])->find($customer->id);
        $currentPlan = $customer->getPlan()?->first();

        // Get available plans
        $availablePlans = Plan::with(['features', 'prices.currency'])
            ->where('is_visible', true)
            ->where('is_disable', false)
            ->get();

        // Get customer's country for pricing (default to Saudi Arabia)
        $customerCountry = Country::where('code', 'SA')->first();
        if (!$customerCountry) {
            $customerCountry = Country::first();
        }
        
        return view('customer.plan-request', compact(
            'customer',
            'currentPlan',
            'availablePlans',
            'customerCountry'
        ));
    }

    /**
     * Create a new plan request (order)
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'order_type' => 'required|in:' . implode(',', [
                Order::TYPE_NEW_SUBSCRIPTION,
                Order::TYPE_UPGRADE,
                Order::TYPE_DOWNGRADE,
                Order::TYPE_RENEWAL
            ]),
            'country_id' => 'nullable|exists:country,id',
        ]);

        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();
        $plan = Plan::findOrFail($request->plan_id);

        // Check if customer already has a pending order for this plan
        if ($this->orderService->hasExistingPendingOrder($customer, $plan)) {
            return back()->withErrors(['error' => 'You already have a pending order for this plan. Please complete or cancel your existing order before creating a new one.']);
        }

        // Check if customer is trying to order their current plan
        $currentPlan = $customer->getPlan()?->first();
        if ($currentPlan && $currentPlan->id == $plan->id && $request->order_type !== Order::TYPE_RENEWAL) {
            return back()->withErrors(['error' => 'You are already subscribed to this plan. Use the renewal option if you want to extend your subscription.']);
        }

        try {
            $order = $this->orderService->createPlanRequest($customer, $plan, [
                'order_type' => $request->order_type,
                'country_id' => $request->country_id,
                'notes' => $request->notes,
            ]);

            // Show success message and redirect to orders page
            return redirect()->route('customer.orders.index')
                ->with('success', 'Plan request created successfully! Your order #' . $order->order_id . ' is now pending payment.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create plan request: ' . $e->getMessage()]);
        }
    }

    /**
     * Show specific order/plan request
     */
    public function show($locale, $order)
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        // Find the order and ensure customer can only view their own orders
        $order = Order::where('id', $order)
                     ->where('customer_id', $customer->id)
                     ->firstOrFail();

        $order->load(['plan', 'previousPlan', 'invoice', 'currency']);

        return view('customer.order-details', compact('order'));
    }

    /**
     * Show customer's order history
     */
    public function orders()
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        $orders = $this->orderService->getOrderHistoryForCustomer($customer);
        $pendingOrders = $this->orderService->getPendingOrdersForCustomer($customer);

        return view('customer.orders', compact('orders', 'pendingOrders'));
    }

    /**
     * Cancel a pending order
     */
    public function cancel(Request $request, $locale, $order)
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        // Find the order and ensure customer can only cancel their own orders
        $order = Order::where('id', $order)
                      ->where('customer_id', $customer->id)
                      ->first();

        if (!$order) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found',
                ], 404);
            }
            abort(404);
        }

        try {
            $this->orderService->cancelOrder($order, 'Cancelled by customer');

            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order cancelled successfully'
                ]);
            }

            return back()->with('success', 'Order cancelled successfully');
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Process payment for an order (simulation for now)
     */
    public function processPayment(Request $request, $locale, $order)
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        // Find the order and ensure customer can only pay for their own orders
        $order = Order::where('id', $order)
                     ->where('customer_id', $customer->id)
                     ->firstOrFail();

        // Can only pay for pending orders
        if (!$order->isPending()) {
            return back()->withErrors(['error' => 'This order is not available for payment']);
        }

        $request->validate([
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
        ]);

        try {
            $success = $this->orderService->processOrderPayment($order, [
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
            ]);

            if ($success) {
                return redirect()->route('customer.dashboard', ['locale' => app()->getLocale()])
                    ->with('success', 'Payment processed successfully! Your subscription has been updated to the ' . $order->plan->name . ' plan.');
            } else {
                return back()->withErrors(['error' => 'Payment processing failed. Please try again or contact support.']);
            }

        } catch (\Exception $e) {
            Log::error('Payment processing failed for order: ' . $order->id, [
                'error' => $e->getMessage(),
                'customer_id' => $customer->id,
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => 'Payment processing failed: ' . $e->getMessage()]);
        }
    }

}
