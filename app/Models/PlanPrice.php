<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanPrice extends Model
{
    protected $table = "plan_prices";
    protected $fillable = [
        "plan_id",
        "country_id",
        "price",
        "currency_id",
    ];

    /**
     * Get the plan that owns this price
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * Get the country for this price
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the currency for this price
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'currency_id');
    }

    /**
     * Get the formatted price with currency symbol
     */
    public function getFormattedPriceAttribute($lang = 'en')
    {
        $symbol = $this->currency ? $this->currency->getSymbol($lang) : '$';
        return $symbol . number_format($this->price, 0);
    }
}
