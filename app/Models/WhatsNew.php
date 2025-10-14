<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsNew extends Model
{
    protected $table = 'whats_new';
    
    protected $fillable = [
        'title',
        'description',
        'hindi_description',
        'image',
        'publish_date',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'publish_date' => 'date',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('publish_date', 'desc');
    }
}
