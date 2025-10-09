<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionFeature extends Model
{
    protected $table = 'subscription_features';

    protected $fillable = [
        'subscription_id',
        'plan_id',
        'max_user',
        'module_account',
        'module_crm',
        'module_pos',
        'module_hrm',
        'more_featrues',
        'is_enabled',
        'feature_config',
    ];

    protected $casts = [
        "more_featrues" => "array",
        'is_enabled' => 'boolean',
        'feature_limit' => 'integer',
    ];

    /**
     * Get the subscription that owns this feature.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    /**
     * Get the feature that this subscription feature belongs to.
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class, 'feature_id');
    }

    /**
     * Check if feature is available (enabled and within limits).
     */
    public function isAvailable(): bool
    {
        return $this->is_enabled;
    }

    /**
     * Get feature limit or return null if unlimited.
     */
    public function getLimit(): ?int
    {
        return $this->feature_limit;
    }

    /**
     * Check if feature has a limit.
     */
    public function hasLimit(): bool
    {
        return $this->feature_limit !== null;
    }

    /**
     * Get feature configuration.
     */
    public function getConfig(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->feature_config ?? [];
        }

        return data_get($this->feature_config, $key, $default);
    }

    /**
     * Set feature configuration.
     */
    public function setConfig(string $key, $value): void
    {
        $config = $this->feature_config ?? [];
        data_set($config, $key, $value);
        $this->feature_config = $config;
    }
}
