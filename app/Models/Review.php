<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'rating',
        'review',
        'service_type',
        'project_name',
        'project_location',
        'is_featured',
        'is_verified',
        'is_active',
        'review_source',
        'external_id'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'integer'
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

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeByServiceType($query, $serviceType)
    {
        return $query->where('service_type', $serviceType);
    }

    // Accessors
    public function getStarRatingAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function getShortReviewAttribute()
    {
        return strlen($this->review_text) > 100 
            ? substr($this->review_text, 0, 100) . '...' 
            : $this->review_text;
    }

    // Static methods
    public static function getAverageRating()
    {
        return self::active()->avg('rating');
    }

    public static function getRatingCounts()
    {
        return self::active()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();
    }

    public static function getTotalReviews()
    {
        return self::active()->count();
    }
}
