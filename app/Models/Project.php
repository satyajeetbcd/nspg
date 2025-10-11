<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'project_type',
        'location',
        'capacity',
        'image_path',
        'image_alt',
        'installation_date',
        'cost',
        'features',
        'is_featured',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'installation_date' => 'date',
        'cost' => 'decimal:2',
        'features' => 'array'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('project_type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getFormattedCostAttribute()
    {
        return $this->cost ? '₹' . number_format($this->cost, 2) : 'N/A';
    }

    public function getFormattedInstallationDateAttribute()
    {
        return $this->installation_date ? $this->installation_date->format('M d, Y') : 'N/A';
    }

    public function getProjectTypeLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->project_type));
    }

    // Static methods
    public static function getProjectTypes()
    {
        return [
            'residential' => 'Residential',
            'commercial' => 'Commercial',
            'industrial' => 'Industrial'
        ];
    }
}
