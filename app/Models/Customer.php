<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, \Illuminate\Auth\MustVerifyEmail;

    protected $guard_name = 'customer';
    protected $information = [
        'name',
        'email',
        'password',
        'avatar',
        'is_active',
        'country',
        'plan',
    ];
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'is_active',
        'email_verified_at',
        'type',
        'created_by',
        'lang',
        'timezone',
        'country',
        'plan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'avatar',
        'ProfileCompletion',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the creator ID for this customer.
     */
    public function creatorId()
    {
        if ($this->type == 'company' || $this->type == 'super admin') {
            return $this->id;
        } else {
            return $this->created_by;
        }
    }



    /**
     * Get profile completion percentage.
     *
     * @return int
     */
    public function getProfileCompletionAttribute(): int
    {
        $total = count($this->information);
        $completed = 0;

        foreach ($this->information as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }

        $percentage = intval(($completed / $total) * 100);

        // Cap at 80% if no country
        if (empty($this->country)) {
            $percentage = min($percentage, 80);
        }

        return $percentage;
    }

    public function getProfileCompletionMessageAttribute(): ?string
    {
        if (empty($this->country)) {
            return "⚠️ Your country must be assigned to complete your profile.";
        }

        return null;
    }


    /**
     * Get the current language for this customer.
     */
    public function currentLanguage()
    {
        return $this->lang;
    }

    /**
     * Get the customer's timezone.
     */
    public function getTimezone()
    {
        return $this->timezone ?? 'UTC';
    }

    /**
     * Get timezone based on locale.
     */
    public function getTimezoneFromLocale()
    {
        $locale = $this->currentLanguage() ?? app()->getLocale();

        // Map common locales to their timezones
        $timezoneMap = [
            'en' => 'UTC',
            'en-US' => 'America/New_York',
            'en-GB' => 'Europe/London',
            'ar' => 'Asia/Riyadh',
            'ar-SA' => 'Asia/Riyadh',
            'ar-AE' => 'Asia/Dubai',
            'ar-EG' => 'Africa/Cairo',
            'fr' => 'Europe/Paris',
            'de' => 'Europe/Berlin',
            'es' => 'Europe/Madrid',
            'it' => 'Europe/Rome',
            'pt' => 'Europe/Lisbon',
            'nl' => 'Europe/Amsterdam',
            'ru' => 'Europe/Moscow',
            'zh' => 'Asia/Shanghai',
            'ja' => 'Asia/Tokyo',
            'ko' => 'Asia/Seoul',
            'hi' => 'Asia/Kolkata',
        ];

        return $timezoneMap[$locale] ?? 'UTC';
    }

    /**
     * Convert UTC datetime to customer's timezone.
     */
    public function toCustomerTimezone($datetime)
    {
        if (!$datetime) {
            return null;
        }

        $timezone = $this->getTimezone();

        if ($datetime instanceof \Carbon\Carbon) {
            return $datetime->setTimezone($timezone);
        }

        return \Carbon\Carbon::parse($datetime)->setTimezone($timezone);
    }

    /**
     * Current subscribed plan for this customer.
     */
    public function getPlan()
    {
        return $this->belongsTo(\App\Models\Plan::class, 'plan', 'id');
    }

    /**
     * Plan relationship.
     */
    public function plan()
    {
        return $this->belongsTo(\App\Models\Plan::class, 'plan', 'id');
    }

    /**
     * Get the current active subscription for this customer.
     */
    public function currentSubscription()
    {
        return $this->subscriptions()
            ->where('end_date', '>', now())
            ->with(['plan', 'plan.features'])
            ->orderBy('end_date', 'desc')
            ->first();
    }

    /**
     * Get all subscriptions for this customer.
     */
    public function subscriptions()
    {
        return $this->hasMany(\App\Models\Subscription::class, 'customer_id');
    }

    /**
     * Get the companies for this customer.
     */
    public function companies()
    {
        return $this->hasMany(CustomerCompany::class);
    }

    /**
     * Get the primary company for this customer.
     */
    public function primaryCompany()
    {
        return $this->hasOne(CustomerCompany::class)->oldest();
    }

    /**
     * Get the invoices for this customer.
     */
    public function invoices()
    {
        return $this->hasMany(\App\Models\Invoice::class, 'customer_id');
    }

    /**
     * Get the orders for this customer.
     */
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'customer_id');
    }


    /**
     * Get the email address that should be used for verification.
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }

    /**
     * Get the customer's status display.
     */
    public function getStatusDisplayAttribute()
    {
        if ($this->is_active && $this->email_verified_at) {
            return 'Active';
        } elseif (!$this->email_verified_at) {
            return 'Email Not Verified';
        } else {
            return 'Inactive';
        }
    }

    /**
     * Check if customer is truly active (verified and enabled).
     */
    public function getIsTrulyActiveAttribute()
    {
        return $this->attributes['is_active'] && $this->email_verified_at;
    }

    /**
     * Get the avatar URL.
     */
    public function getAvatarAttribute()
    {
        if (isset($this->attributes['avatar']) && !empty($this->attributes['avatar'])) {
            return asset('storage/' . $this->attributes['avatar']);
        }

        // Return a data URI for the default avatar (SVG)
        $defaultAvatar = 'data:image/svg+xml;base64,' . base64_encode('
            <svg width="150" height="150" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <circle cx="75" cy="75" r="75" fill="url(#grad1)"/>
                <circle cx="75" cy="60" r="25" fill="white" opacity="0.9"/>
                <path d="M30 120 Q75 100 120 120 L120 150 L30 150 Z" fill="white" opacity="0.9"/>
            </svg>
        ');

        return $defaultAvatar;
    }
}
