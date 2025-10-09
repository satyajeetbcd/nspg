<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmailAttempt extends Model
{
    protected $fillable = [
        'email',
        'type',
        'action',
        'customer_id',
        'related_id',
        'related_type',
        'token',
        'expires_at',
        'is_used',
        'used_at',
        'attempt_count',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    /**
     * Check if email can be sent (max 2 attempts)
     */
    public static function canSendEmail($email, $type, $action, $customerId = null, $relatedId = null, $relatedType = null)
    {
        $query = self::where('email', $email)
            ->where('type', $type)
            ->where('action', $action);
            
        if ($customerId) {
            $query->where('customer_id', $customerId);
        }
        
        if ($relatedId && $relatedType) {
            $query->where('related_id', $relatedId)
                  ->where('related_type', $relatedType);
        }
        
        $existingAttempts = $query->count();
        return $existingAttempts < 2;
    }

    /**
     * Create or update email attempt record
     */
    public static function createAttempt($email, $type, $action, $customerId = null, $relatedId = null, $relatedType = null, $expirationHours = 24)
    {
        // Check if we can send
        if (!self::canSendEmail($email, $type, $action, $customerId, $relatedId, $relatedType)) {
            return null;
        }

        // Check for existing attempt
        $query = self::where('email', $email)
            ->where('type', $type)
            ->where('action', $action);
            
        if ($customerId) {
            $query->where('customer_id', $customerId);
        }
        
        if ($relatedId && $relatedType) {
            $query->where('related_id', $relatedId)
                  ->where('related_type', $relatedType);
        }
        
        $existingAttempt = $query->first();

        if ($existingAttempt) {
            // Update existing attempt
            $existingAttempt->update([
                'token' => Str::random(64),
                'expires_at' => Carbon::now()->addHours($expirationHours),
                'attempt_count' => $existingAttempt->attempt_count + 1,
                'is_used' => false,
                'used_at' => null,
            ]);
            return $existingAttempt;
        } else {
            // Create new attempt
            return self::create([
                'email' => $email,
                'type' => $type,
                'action' => $action,
                'customer_id' => $customerId,
                'related_id' => $relatedId,
                'related_type' => $relatedType,
                'token' => Str::random(64),
                'expires_at' => Carbon::now()->addHours($expirationHours),
                'attempt_count' => 1,
            ]);
        }
    }

    /**
     * Validate token and mark as used
     */
    public static function validateAndUseToken($token)
    {
        $attempt = self::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->where('is_used', false)
            ->first();

        if ($attempt) {
            $attempt->update([
                'is_used' => true,
                'used_at' => Carbon::now(),
            ]);
            return $attempt;
        }

        return null;
    }

    /**
     * Check if token is valid
     */
    public static function isTokenValid($token)
    {
        return self::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->where('is_used', false)
            ->exists();
    }

    /**
     * Get remaining attempts for email/type/action combination
     */
    public static function getRemainingAttempts($email, $type, $action, $customerId = null, $relatedId = null, $relatedType = null)
    {
        $query = self::where('email', $email)
            ->where('type', $type)
            ->where('action', $action);
            
        if ($customerId) {
            $query->where('customer_id', $customerId);
        }
        
        if ($relatedId && $relatedType) {
            $query->where('related_id', $relatedId)
                  ->where('related_type', $relatedType);
        }
        
        $attempts = $query->count();
        return max(0, 2 - $attempts);
    }

    /**
     * Clean up expired attempts
     */
    public static function cleanupExpired()
    {
        return self::where('expires_at', '<', Carbon::now())->delete();
    }
}
