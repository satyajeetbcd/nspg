<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyLang extends Model
{
    protected $table = 'currency_lang';

    protected $fillable = [
        'currency_id',
        'lang',
        'name',
        'symbol',
    ];

    public $timestamps = false;

    /**
     * Get the currency
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'currency_id');
    }
}

