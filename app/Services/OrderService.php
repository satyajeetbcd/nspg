<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    /**
     * Create a plan request (order) for a customer
     */
    public function createPlanRequest(Customer $customer, Plan $plan, array $options = []): Order
    {
        $currentPlan = $customer->getPlan()->first();
        $orderType = $this->determineOrderType($currentPlan, $plan, $options['order_type'] ?? null);

        // Get plan price for customer's country
        $countryId = $options['country_id'] ?? null;
        $planPrice = $plan->getPriceForCountry($countryId);

        if (!$planPrice) {
            throw new \Exception('Price not available for the selected plan and country');
        }

        return DB::transaction(function () use ($customer, $plan, $currentPlan, $orderType, $planPrice, $options) {
            return Order::create([
                'customer_id' => $customer->id,
                'plan_id' => $plan->id,
                'previous_plan_id' => $currentPlan?->id,
                'price' => $planPrice->price,
                'currency_id' => $planPrice->currency->currency_id,
                'payment_status' => Order::STATUS_PENDING,
                'order_type' => $orderType,
                'paid' => null, // null indicates pending payment
                'notes' => $options['notes'] ?? null,
            ]);
        });
    }

    /**
     * Process payment for an order and create subscription/invoice
     */
    public function processOrderPayment(Order $order, array $paymentData): bool
    {
        if (!$order->isPending()) {
            throw new \Exception('Order is not available for payment');
        }

        return DB::transaction(function () use ($order, $paymentData) {
            try {
                // Mark order as paid
                $order->markAsPaid(
                    $paymentData['transaction_id'] ?? 'TXN-' . time(),
                    $paymentData['payment_method'] ?? 'unknown'
                );

                // Create/update subscription
                $subscription = $this->processOrderToSubscription($order);

                // Generate invoice
                $invoice = $this->generateInvoiceFromOrder($order);

                Log::info('Order payment processed successfully', [
                    'order_id' => $order->id,
                    'customer_id' => $order->customer_id,
                    'subscription_id' => $subscription?->id,
                    'invoice_id' => $invoice?->id,
                ]);

                return true;

            } catch (\Exception $e) {
                Log::error('Order payment processing failed', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }
        });
    }

    /**
     * Convert paid order to subscription
     */
    public function processOrderToSubscription(Order $order): ?Subscription
    {
        $customer = $order->customer;
        $plan = $order->plan;

        // Calculate subscription dates
        $startDate = now();
        $endDate = $this->calculateSubscriptionEndDate($plan, $startDate);

        $subscription = null;
        switch ($order->order_type) {
            case Order::TYPE_NEW_SUBSCRIPTION:
                $subscription = $this->createNewSubscription($customer, $plan, $startDate, $endDate, $order);
                break;

            case Order::TYPE_UPGRADE:
            case Order::TYPE_DOWNGRADE:
                $subscription = $this->upgradeSubscription($customer, $plan, $startDate, $endDate, $order);
                break;

            case Order::TYPE_RENEWAL:
                $subscription = $this->renewSubscription($customer, $plan, $order);
                break;

            default:
                throw new \Exception('Unknown order type: ' . $order->order_type);
        }

        // Link the subscription back to the order
        if ($subscription) {
            $order->update(['subscription_id' => $subscription->id]);
        }

        return $subscription;
    }

    /**
     * Generate invoice from paid order
     */
    public function generateInvoiceFromOrder(Order $order): Invoice
    {
        $customer = $order->customer;
        $company = $customer->primaryCompany;

        return $customer->invoices()->create([
            'company_id' => $company?->id, // This can be null if customer has no company
            'subscription_id' => $order->subscription_id,
            'plan_id' => $order->plan_id,
            'order_id' => $order->id,
            'amount' => $order->price,
            'currency_id' => $order->currency_id,
            'status' => 'paid',
            'due_date' => now(),
        ]);
    }

    /**
     * Cancel an order
     */
    public function cancelOrder(Order $order): bool
    {
        if (!$order->isPending()) {
            throw new \Exception('Only pending orders can be cancelled');
        }

        return $order->update([
            'payment_status' => Order::STATUS_CANCELLED,
            'notes' => ($order->notes ?? '') . "\nCancelled: " . ($reason ?? 'Cancelled by customer') . " on " . now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get pending orders for a customer
     */
    public function getPendingOrdersForCustomer(Customer $customer)
    {
        return $customer->orders()
            ->pending()
            ->excludeCancelled()
            ->with(['plan', 'previousPlan', 'currency'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get order history for a customer
     */
    public function getOrderHistoryForCustomer(Customer $customer, int $perPage = 15)
    {
        return $customer->orders()
            ->excludeCancelled()
            ->with(['plan', 'previousPlan', 'invoice', 'currency'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Check if customer has any pending orders for a specific plan
     */
    public function hasExistingPendingOrder(Customer $customer, Plan $plan): bool
    {
        return $customer->orders()
            ->pending()
            ->excludeCancelled()
            ->where('plan_id', $plan->id)
            ->where('created_at', '>', now()->subDays(1)) // Only check orders from last 24 hours
            ->exists();
    }

    /**
     * Check if customer has any pending orders of any type
     */
    public function hasAnyPendingOrders(Customer $customer): bool
    {
        return $customer->orders()
            ->pending()
            ->excludeCancelled()
            ->where('created_at', '>', now()->subDays(7)) // Check orders from last 7 days
            ->exists();
    }

    /**
     * Determine order type based on current and new plan
     */
    private function determineOrderType(?Plan $currentPlan, Plan $newPlan, ?string $explicitType = null): string
    {
        if ($explicitType) {
            return $explicitType;
        }

        if (!$currentPlan) {
            return Order::TYPE_NEW_SUBSCRIPTION;
        }

        if ($currentPlan->id === $newPlan->id) {
            return Order::TYPE_RENEWAL;
        }

        // Compare plan prices to determine upgrade/downgrade
        // This is simplified - you might want more sophisticated logic
        $currentPrice = $currentPlan->prices()->first()?->price ?? 0;
        $newPrice = $newPlan->prices()->first()?->price ?? 0;

        return $newPrice > $currentPrice ? Order::TYPE_UPGRADE : Order::TYPE_DOWNGRADE;
    }

    /**
     * Calculate subscription end date based on plan duration
     */
    private function calculateSubscriptionEndDate(Plan $plan, Carbon $startDate): Carbon
    {
        return match($plan->duration) {
            'month' => $startDate->copy()->addMonth(),
            'year' => $startDate->copy()->addYear(),
            'lifetime' => $startDate->copy()->addYears(99),
            'one_time' => $startDate->copy()->addYear(), // One-time plans last 1 year
            default => $startDate->copy()->addMonth()
        };
    }

    /**
     * Create new subscription
     */
    private function createNewSubscription(Customer $customer, Plan $plan, Carbon $startDate, Carbon $endDate, Order $order): Subscription
    {
        return $customer->subscriptions()->create([
            'order_id' => $order->id,
            'plan_id' => $plan->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'grace_date' => $endDate->copy()->addDays(7), // 7 days grace period
            'amount' => $order->price,
            'currency' => $order->currency->currency_name ?? 'USD',
        ]);
    }

    /**
     * Upgrade/downgrade subscription
     */
    private function upgradeSubscription(Customer $customer, Plan $plan, Carbon $startDate, Carbon $endDate, Order $order): Subscription
    {
        // End current subscription gracefully
        $currentSubscription = $customer->currentSubscription();
        if ($currentSubscription) {
            // Set end date to now, but preserve grace period
            $currentSubscription->update([
                'end_date' => now(),
                'grace_date' => now()->addDays(3) // Give 3 days grace for the transition
            ]);

            Log::info('Ended current subscription for upgrade', [
                'customer_id' => $customer->id,
                'old_subscription_id' => $currentSubscription->id,
                'old_plan_id' => $currentSubscription->plan_id,
                'new_plan_id' => $plan->id
            ]);
        }

        // Create new subscription
        return $this->createNewSubscription($customer, $plan, $startDate, $endDate, $order);
    }

    /**
     * Renew subscription
     */
    private function renewSubscription(Customer $customer, Plan $plan, Order $order): Subscription
    {
        $currentSubscription = $customer->currentSubscription();

        if ($currentSubscription && $currentSubscription->plan_id === $plan->id) {
            // Extend current subscription
            $newEndDate = $currentSubscription->end_date->gt(now())
                ? $currentSubscription->end_date
                : now();

            $newEndDate = $this->calculateSubscriptionEndDate($plan, $newEndDate);

            $currentSubscription->update([
                'end_date' => $newEndDate,
                'grace_date' => $newEndDate->copy()->addDays(7),
                'order_id' => $order->id, // Link to the renewal order
            ]);

            return $currentSubscription;
        } else {
            // Create new subscription if no current one or different plan
            $startDate = now();
            $endDate = $this->calculateSubscriptionEndDate($plan, $startDate);
            return $this->createNewSubscription($customer, $plan, $startDate, $endDate, $order);
        }
    }
}
