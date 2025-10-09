<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CountryLang extends Model
{
    protected $table = 'country_lang';

    protected $fillable = [
        'country_id',
        'lang',
        'name',
    ];

    public $timestamps = false;

    /**
     * Get the country
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}

