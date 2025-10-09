<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TimezoneService
{
    /**
     * Get the current user's timezone.
     */
    public static function getUserTimezone()
    {
        $user = Auth::guard('customer')->user();

        if ($user instanceof \App\Models\Customer) {
            return $user->getTimezone();
        }

        return 'UTC';
    }

    /**
     * Convert UTC datetime to user's timezone.
     */
    public static function toUserTimezone($datetime, $timezone = null)
    {
        if (!$datetime) {
            return null;
        }

        $userTimezone = $timezone ?? self::getUserTimezone();

        if ($datetime instanceof Carbon) {
            return $datetime->setTimezone($userTimezone);
        }

        return Carbon::parse($datetime)->setTimezone($userTimezone);
    }

    /**
     * Convert user's datetime to UTC for storage.
     */
    public static function toUTC($datetime, $timezone = null)
    {
        if (!$datetime) {
            return null;
        }

        $userTimezone = $timezone ?? self::getUserTimezone();

        if ($datetime instanceof Carbon) {
            return $datetime->setTimezone('UTC');
        }

        return Carbon::parse($datetime, $userTimezone)->utc();
    }

    /**
     * Format datetime for display in user's timezone.
     */
    public static function formatForUser($datetime, $format = 'M d, Y h:i A', $timezone = null)
    {
        $converted = self::toUserTimezone($datetime, $timezone);

        if (!$converted) {
            return null;
        }

        return $converted->format($format);
    }

    /**
     * Get timezone from locale.
     */
    public static function getTimezoneFromLocale($locale)
    {
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
     * Get all available timezones grouped by region.
     */
    public static function getAvailableTimezones()
    {
        return [
            'UTC' => ['UTC' => 'UTC'],
            'America' => [
                'America/New_York' => 'Eastern Time (US & Canada)',
                'America/Chicago' => 'Central Time (US & Canada)',
                'America/Denver' => 'Mountain Time (US & Canada)',
                'America/Los_Angeles' => 'Pacific Time (US & Canada)',
                'America/Toronto' => 'Toronto',
                'America/Vancouver' => 'Vancouver',
                'America/Sao_Paulo' => 'São Paulo',
                'America/Argentina/Buenos_Aires' => 'Buenos Aires',
            ],
            'Europe' => [
                'Europe/London' => 'London',
                'Europe/Paris' => 'Paris',
                'Europe/Berlin' => 'Berlin',
                'Europe/Rome' => 'Rome',
                'Europe/Madrid' => 'Madrid',
                'Europe/Amsterdam' => 'Amsterdam',
                'Europe/Moscow' => 'Moscow',
                'Europe/Istanbul' => 'Istanbul',
            ],
            'Asia' => [
                'Asia/Dubai' => 'Dubai',
                'Asia/Riyadh' => 'Riyadh',
                'Asia/Kolkata' => 'Mumbai, Delhi',
                'Asia/Shanghai' => 'Beijing, Shanghai',
                'Asia/Tokyo' => 'Tokyo',
                'Asia/Seoul' => 'Seoul',
                'Asia/Singapore' => 'Singapore',
                'Asia/Bangkok' => 'Bangkok',
            ],
            'Africa' => [
                'Africa/Cairo' => 'Cairo',
                'Africa/Johannesburg' => 'Johannesburg',
                'Africa/Lagos' => 'Lagos',
                'Africa/Casablanca' => 'Casablanca',
            ],
            'Australia' => [
                'Australia/Sydney' => 'Sydney',
                'Australia/Melbourne' => 'Melbourne',
                'Australia/Perth' => 'Perth',
                'Pacific/Auckland' => 'Auckland',
            ],
        ];
    }
}
