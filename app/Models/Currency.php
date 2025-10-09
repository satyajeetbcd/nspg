<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    protected $table = 'currency';

    protected $fillable = [
        'country_id',
        'currency_id',
    ];

    public $timestamps = false;

    /**
     * Get the country
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the currency languages
     */
    public function currencyLanguages(): HasMany
    {
        return $this->hasMany(CurrencyLang::class, 'currency_id', 'currency_id');
    }

    /**
     * Alias for currencyLanguages relationship
     */
    public function lang(): HasMany
    {
        return $this->currencyLanguages();
    }

    /**
     * Get the currency name for a specific language
     */
    public function getNameForLanguage($lang = 'en')
    {
        $currencyLang = $this->currencyLanguages()->where('lang', $lang)->first();
        return $currencyLang ? $currencyLang->name : 'USD';
    }

    public function getNameattribute()
    {
        $lang = app()->getLocale() ?? 'en';
        $currencyLang = $this->currencyLanguages()->where('lang', $lang)->first();
        return $currencyLang ? $currencyLang->name : 'USD';
    }
    public function getSymbolattribute()
    {
        $lang = app()->getLocale() ?? 'en';
        $currencyLang = $this->currencyLanguages()->where('lang', $lang)->first();
        return $currencyLang ? $currencyLang->name : 'USD';
    }

    /**
     * Get the currency symbol for this currency
     */
    public function getSymbol($lang = 'en')
    {
        $currencyLang = $this->currencyLanguages()->where('lang', $lang)->first();

        if ($currencyLang && $currencyLang->symbol) {
            return $currencyLang->symbol;
        }

        // Fallback to default symbol if not found in database
        return '$';
    }
}
