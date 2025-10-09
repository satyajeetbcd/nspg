<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

// Services
use App\Services\OrderService;

class Order extends Model
{
    // Order status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';

    // Order type constants
    const TYPE_NEW_SUBSCRIPTION = 'new_subscription';
    const TYPE_UPGRADE = 'upgrade';
    const TYPE_DOWNGRADE = 'downgrade';
    const TYPE_RENEWAL = 'renewal';

    protected $fillable = [
        'order_id',
        'customer_id',
        'plan_id',
        'previous_plan_id',
        'price',
        'price_currency',
        'currency_id',
        'txn_id',
        'payment_status',
        'payment_type',
        'user_id',
        'order_type',
        'notes',
        'paid',
        'paid_at',
        'subscription_id',
    ];

    protected $casts = [
        'paid' => 'boolean',
        'paid_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    /**
     * Get the customer that owns this order
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the plan for this order
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the previous plan for upgrade/downgrade orders
     */
    public function previousPlan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'previous_plan_id');
    }

    /**
     * Get the invoice generated from this order (if paid)
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Get the subscription created from this order (if paid)
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Get the currency for this order
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'currency_id');
    }

    /**
     * Get the invoices generated from this order
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'order_id', 'id');
    }

    /**
     * Generate unique order ID
     */
    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->order_id)) {
                $order->order_id = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
            }
        });
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->paid === true || $this->payment_status === self::STATUS_PAID;
    }

    /**
     * Check if order is pending payment
     */
    public function isPending(): bool
    {
        return $this->payment_status === self::STATUS_PENDING || $this->paid === null;
    }

    /**
     * Mark order as paid
     */
    public function markAsPaid($transactionId = null, $paymentType = null): void
    {
        $this->update([
            'paid' => true,
            'paid_at' => now(),
            'payment_status' => self::STATUS_PAID,
            'txn_id' => $transactionId ?? $this->txn_id,
            'payment_type' => $paymentType ?? $this->payment_type,
        ]);
    }

    /**
     * Get order type display name
     */
    public function getOrderTypeDisplayAttribute(): string
    {
        return match($this->order_type) {
            self::TYPE_NEW_SUBSCRIPTION => 'New Subscription',
            self::TYPE_UPGRADE => 'Plan Upgrade',
            self::TYPE_DOWNGRADE => 'Plan Downgrade',
            self::TYPE_RENEWAL => 'Subscription Renewal',
            default => 'Unknown'
        };
    }

    /**
     * Get payment status display name
     */
    public function getPaymentStatusDisplayAttribute(): string
    {
        return match($this->payment_status) {
            self::STATUS_PENDING => 'Pending Payment',
            self::STATUS_PAID => 'Paid',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_FAILED => 'Payment Failed',
            self::STATUS_REFUNDED => 'Refunded',
            default => 'Unknown'
        };
    }

    /**
     * Scope for pending orders
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', self::STATUS_PENDING)
                    ->orWhereNull('paid')
                    ->orWhere('paid', false);
    }

    /**
     * Scope for paid orders
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', self::STATUS_PAID)
                    ->orWhere('paid', true);
    }

    /**
     * Scope for specific customer
     */
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope to exclude cancelled orders
     */
    public function scopeExcludeCancelled($query)
    {
        return $query->where('payment_status', '!=', self::STATUS_CANCELLED);
    }

    public static function total_orders()
    {
        return Order::count();
    }

    public static function total_orders_price()
    {
        return Order::sum('price');
    }

    public function total_coupon_used()
    {
        return $this->hasOne('App\Models\UserCoupon', 'order', 'order_id');
    }

    /**
     * Accept this order without card payment and generate an invoice.
     * Intended for staff usage (e.g., cash, bank transfer, etc.).
     *
     * Returns the created Invoice instance.
     */
    public function acceptByStaff(string $paymentType = 'cash', ?string $notes = null): Invoice
    {
        if (!$this->isPending()) {
            throw new \Exception('Only pending orders can be accepted.');
        }

        return DB::transaction(function () use ($paymentType, $notes) {
            // Mark order as paid using an offline transaction id
            $this->markAsPaid('OFFLINE-' . time(), $paymentType);

            // Append staff notes if provided
            if (!empty($notes)) {
                $this->update([
                    'notes' => trim(($this->notes ?? '') . (empty($this->notes) ? '' : "\n") . 'Staff acceptance note: ' . $notes),
                ]);
            }

            // Build subscription and invoice via service to keep logic consistent
            /** @var OrderService $service */
            $service = app(OrderService::class);

            // Create/adjust subscription based on order type
            $service->processOrderToSubscription($this);

            // Generate invoice using order data (amount, currency)
            $invoice = $service->generateInvoiceFromOrder($this);

            return $invoice;
        });
    }
}
