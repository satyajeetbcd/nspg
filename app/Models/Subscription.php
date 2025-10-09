<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'order_id',
        'customer_id',
        'plan_id',
        'start_date',
        'end_date',
        'grace_date',
        'status',
        'amount',
        'currency',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'grace_date' => 'datetime',
    ];

    /**
     * Get the customer that owns this subscription.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the plan for this subscription.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * Get the order that created this subscription.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Check if subscription is active.
     */
    public function isActive(): bool
    {
        return $this->end_date > now();
    }

    /**
     * Check if subscription is in grace period.
     */
    public function isInGracePeriod(): bool
    {
        return $this->grace_date && $this->grace_date > now() && $this->end_date <= now();
    }

    /**
     * Get subscription status.
     */
    public function getStatusAttribute(): string
    {
        if ($this->isActive()) {
            return 'active';
        } elseif ($this->isInGracePeriod()) {
            return 'grace_period';
        } else {
            return 'expired';
        }
    }

    /**
     * Get days remaining until expiration.
     */
    public function getDaysRemainingAttribute(): int
    {
        if ($this->isActive()) {
            return now()->diffInDays($this->end_date, false);
        }
        return 0;
    }

    /**
     * Check if subscription is expired.
     */
    public function isExpired(): bool
    {
        return $this->end_date <= now() && (!$this->grace_date || $this->grace_date <= now());
    }

    /**
     * Get subscription status with more detailed information.
     */
    public function getDetailedStatusAttribute(): array
    {
        $status = $this->status;
        $daysRemaining = $this->days_remaining;
        
        return [
            'status' => $status,
            'days_remaining' => $daysRemaining,
            'is_active' => $this->isActive(),
            'is_in_grace' => $this->isInGracePeriod(),
            'is_expired' => $this->isExpired(),
            'end_date' => $this->end_date,
            'grace_date' => $this->grace_date,
        ];
    }

    /**
     * Scope to get active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('end_date', '>', now());
    }

    /**
     * Scope to get expired subscriptions.
     */
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<=', now())
                    ->where(function($q) {
                        $q->whereNull('grace_date')
                          ->orWhere('grace_date', '<=', now());
                    });
    }

    /**
     * Scope to get subscriptions in grace period.
     */
    public function scopeInGracePeriod($query)
    {
        return $query->where('end_date', '<=', now())
                    ->where('grace_date', '>', now());
    }

    /**
     * Get the subscription features for this subscription.
     */
    public function subscriptionFeatures()
    {
        return $this->hasMany(SubscriptionFeature::class, 'subscription_id');
    }

    /**
     * Get enabled subscription features.
     */
    public function enabledFeatures()
    {
        return $this->subscriptionFeatures()->where('is_enabled', true);
    }

    /**
     * Check if subscription has a specific feature.
     */
    public function hasFeature(string $featureName): bool
    {
        return $this->enabledFeatures()
            ->where('feature_name', $featureName)
            ->exists();
    }

    /**
     * Get a specific feature for this subscription.
     */
    public function getFeature(string $featureName): ?SubscriptionFeature
    {
        return $this->enabledFeatures()
            ->where('feature_name', $featureName)
            ->first();
    }
}



