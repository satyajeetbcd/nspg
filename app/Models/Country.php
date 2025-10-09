<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $table = 'country';

    protected $fillable = [
        'code',
    ];

    public $timestamps = false;

    /**
     * Get the country languages
     */
    public function countryLanguages(): HasMany
    {
        return $this->hasMany(CountryLang::class, 'country_id');
    }

    /**
     * Get the country name for a specific language
     */
    public function getNameForLanguage($lang = 'en')
    {
        $countryLang = $this->countryLanguages()->where('lang', $lang)->first();
        return $countryLang ? $countryLang->name : $this->code;
    }


    public function getNameAttribute()
    {
        $lang = app()->getLocale() ?? 'en';
        $countryLang = $this->countryLanguages()->where('lang', $lang)->first();
        return $countryLang ? $countryLang->name : $this->code;
    }

    /**
     * Get the currency for this country
     */
    public function currencies(): HasMany
    {
        return $this->hasMany(Currency::class, 'country_id');
    }

    /**
     * Get the primary currency for this country
     */
    public function primaryCurrency()
    {
        return $this->currencies()->first();
    }
}
