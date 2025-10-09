<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'max_users',
        'user_price',
        'customers_price',
        'storage_price',
        'venders_price',
        'clients_price',
        'trial',
        'trial_days',
        'description',
        'image',
        'is_disable',
        'is_visible',
    ];

    protected $casts = [
        'trial' => 'boolean',
        'is_disable' => 'boolean',
        'is_visible' => 'boolean',
    ];
protected $appends = ['name'];
    public static $arrDuration = [
        'month' => 'Per Month',
        'year' => 'Per Year',
        'one time' => 'One Time',
        'month-ex' => 'Month-ex',
        'year-ex' => 'Year-ex',
        'lifetime' => 'Lifetime'
    ];


    public function modules()
    {
        return $this->features->flatMap->modules(); // collection of all active modules
    }
    public function status()
    {
        return [
            __('lifetime'),
            __('Per Month'),
            __('Per Year'),
        ];
    }

    public static function total_plan()
    {
        return Plan::count();
    }

    public static function most_purchese_plan()
    {
        //        $free_plan = Plan::where('price', '<=', 0)->first()->id;
        $plan =  User::select(DB::raw('count(*) as total'), 'plan')->where('type', '=', 'company')->groupBy('plan')->first();

        return $plan;
    }


    /**
     * Get prices for this plan
     */
    public function prices(): HasMany
    {
        return $this->hasMany(PlanPrice::class, 'plan_id');
    }

    /**
     * Get features for this plan
     */
    public function features(): HasMany
    {
        return $this->hasMany(PlanFeature::class, 'plan_id');
    }

    /**
     * Get subscriptions for this plan
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'plan_id', 'id');
    }

    /**
     * Get customers who are subscribed to this plan
     */
    public function subscribers(): HasMany
    {
        return $this->hasMany(Customer::class, 'plan', 'id');
    }

    /**
     * Get price for a specific country
     */
    public function getPriceForCountry($countryId)
    {
        $planPrice = $this->prices()->where('country_id', $countryId)->first();
        return $planPrice ?: $this->prices()->first();
    }

    /**
     * Get the plan name from the lang table
     */
    public function getNameForLanguage($language = 'en')
    {
        $planLang = DB::table('plan_lang')->where('plan_id', $this->id)->where('lang', $language)->first();
        return $planLang ? $planLang->name : $this->name;
    }
    /**
     * Get the plan Description from the lang table
     */
    public function getDescriptionForLanguage($language = 'en')
    {
        $planLang = DB::table('plan_lang')->where('plan_id', $this->id)->where('lang', $language)->first();
        return $planLang ? $planLang->name : $this->nadescription;
    }

    /**
     * Updae Plan Language
     */
    public function updateLanguage($id, $description, $name) : bool
    {
        $language = app()->getLocale();
        $planLang = DB::table('plan_lang')->where('plan_id', $id)->where('lang', $language)->update([
            'name' => $name ?: $this->name,
            'description' => $description ?: $this->description
        ]);
        return true;
    }

    /**
     * Get name attribute with language support
     */
    public function getNameAttribute(): string
    {
        // Get name from lang table, fallback to default
        $language = app()->getLocale() ?? 'en';
        return $this->getNameForLanguage($language);
    }

    /**
     * Get formatted price for a specific country and language
     */
    public function getFormattedPrice($countryId = null, $language = 'en')
    {
        $planPrice = $this->getPriceForCountry($countryId);

        if ($planPrice) {
            $symbol = $planPrice->currency ? $planPrice->currency->getSymbol($language) : '$';
            return $symbol . number_format($planPrice->price, 0);
        }

        // Fallback to default price if no country-specific price found
        return '$0';
    }

    /**
     * Static method to get plan by ID (simplified without caching)
     */
    public static function getPlan($id)
    {
        return self::find($id);
    }
}
