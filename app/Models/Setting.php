<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'language_code',
    ];

    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Get a setting value by group and key with language support
     * Generic settings (language_code = null) are shared across all languages
     */
    public static function getValue(string $group, string $key, mixed $default = null, ?string $languageCode = null): mixed
    {
        $languageCode = $languageCode ?? app()->getLocale();

        // First, try to get language-specific setting
        $setting = static::where('group', $group)
            ->where('key', $key)
            ->where('language_code', $languageCode)
            ->first();

        // If not found, try to get generic setting (language_code = null)
        if (!$setting) {
            $setting = static::where('group', $group)
                ->where('key', $key)
                ->whereNull('language_code')
                ->first();
        }

        // Fallback to default language (en) if not found in requested language or generic
        if (!$setting && $languageCode !== 'en') {
            $setting = static::where('group', $group)
                ->where('key', $key)
                ->where('language_code', 'en')
                ->first();
        }

        if (!$setting) {
            return $default;
        }

        return match ($setting->type) {
            'int' => (int) $setting->value,
            'bool' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($setting->value, true),
            'float' => (float) $setting->value,
            default => $setting->value,
        };
    }

    /**
     * Set a setting value with language support
     * Pass null as languageCode to create a generic setting (shared across all languages)
     */
    public static function setValue(string $group, string $key, mixed $value, ?string $type = null, ?string $languageCode = 'en'): void
    {
        $type = $type ?? gettype($value);

        if (is_array($value)) {
            $value = json_encode($value);
            $type = 'json';
        }

        static::updateOrCreate(
            ['group' => $group, 'key' => $key, 'language_code' => $languageCode],
            [
                'value' => (string) $value,
                'type' => $type,
            ]
        );
    }

    /**
     * Get all settings for a group with language support
     * Includes both language-specific and generic settings
     */
    public static function getGroup(string $group, ?string $languageCode = null): array
    {
        $languageCode = $languageCode ?? app()->getLocale();

        // Get language-specific settings
        $languageSettings = static::where('group', $group)
            ->where('language_code', $languageCode)
            ->get();

        // Get generic settings (language_code = null)
        $genericSettings = static::where('group', $group)
            ->whereNull('language_code')
            ->get();

        // Merge settings, with language-specific taking precedence over generic
        $allSettings = $genericSettings->concat($languageSettings);

        return $allSettings->mapWithKeys(function ($setting) {
            return [$setting->key => match ($setting->type) {
                'int' => (int) $setting->value,
                'bool' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
                'json' => json_decode($setting->value, true),
                'float' => (float) $setting->value,
                default => $setting->value,
            }];
        })->toArray();
    }

    /**
     * Get all available languages for settings
     */
    public static function getAvailableLanguages(): array
    {
        return static::distinct('language_code')
            ->pluck('language_code')
            ->filter()
            ->values()
            ->toArray();
    }

    /**
     * Get settings for all languages
     */
    public static function getAllLanguagesGroup(string $group): array
    {
        return static::where('group', $group)
            ->get()
            ->groupBy('language_code')
            ->map(function ($settings) {
                return $settings->mapWithKeys(function ($setting) {
                    return [$setting->key => match ($setting->type) {
                        'int' => (int) $setting->value,
                        'bool' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
                        'json' => json_decode($setting->value, true),
                        'float' => (float) $setting->value,
                        default => $setting->value,
                    }];
                })->toArray();
            })
            ->toArray();
    }
}
