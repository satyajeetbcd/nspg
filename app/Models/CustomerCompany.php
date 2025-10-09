<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerCompany extends Model
{
    protected $table = 'customer_companies';

    protected $fillable = [
        'customer_id',
        'company_name',
        'cr_number',
        'vat_number',
        'country_id',
        'city_id',
        'address',
        'currency_id',
        'phone',
        'billing_phone',
        'language',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that owns the company.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the country for this company.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the currency for this company.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the full address for this company.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city_id ? 'City ID: ' . $this->city_id : null,
            $this->country_id ? 'Country ID: ' . $this->country_id : null,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Get the primary phone number (billing phone or regular phone).
     */
    public function getPrimaryPhoneAttribute(): ?string
    {
        return $this->billing_phone ?: $this->phone;
    }
}
