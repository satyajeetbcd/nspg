<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class Settings
{
    private static ?array $cachedSettings = null;
    private const CACHE_TTL = 3600; // 1 hour cache

    public function __construct(
        private ?int $tenantId = null,
    ) {}

    protected function cacheKey(?string $languageCode = null): string
    {
        $lang = $languageCode ?? app()->getLocale();
        return $this->tenantId ? "settings:tenant:{$this->tenantId}:{$lang}" : "settings:global:{$lang}";
    }

    /**
     * Get all settings with optimized caching and language support
     */
    public function all(?string $languageCode = null): array
    {
        $languageCode = $languageCode ?? app()->getLocale();

        // Use static cache first for maximum performance
        if (self::$cachedSettings !== null && isset(self::$cachedSettings[$languageCode])) {
            return self::$cachedSettings[$languageCode];
        }

        // Fallback to Laravel cache
        $cachedData = Cache::remember($this->cacheKey($languageCode), self::CACHE_TTL, function () use ($languageCode) {
            $query = Setting::query();
            if ($this->tenantId) {
                $query->where('tenant_id', $this->tenantId);
            }

            // Get both language-specific and generic settings
            $languageSettings = (clone $query)->where('language_code', $languageCode)->get();
            $genericSettings = (clone $query)->whereNull('language_code')->get();

            // Merge settings, with language-specific taking precedence
            $allSettings = $genericSettings->concat($languageSettings);

            return $allSettings->reduce(function (array $carry, $setting) {
                $carry[$setting->group][$setting->key] = $this->cast($setting->value, $setting->type);
                return $carry;
            }, []);
        });

        // Initialize static cache if needed
        if (self::$cachedSettings === null) {
            self::$cachedSettings = [];
        }
        self::$cachedSettings[$languageCode] = $cachedData;

        return $cachedData;
    }

    /**
     * Get a specific setting value with language support
     */
    public function get(string $path, mixed $default = null, ?string $languageCode = null): mixed
    {
        return Arr::get($this->all($languageCode), $path, $default);
    }

    /**
     * Set a setting value and clear cache with language support
     * Pass null as languageCode to create a generic setting (shared across all languages)
     */
    public function set(string $group, string $key, mixed $value, ?string $type = null, ?string $languageCode = 'en'): void
    {
        Setting::setValue($group, $key, $value, $type, $languageCode);
        $this->clearCache();
    }

    /**
     * Get website setting with language support
     * Pass null as lang to get generic setting (shared across all languages)
     */
    public function getWebsiteSetting(string $key, ?string $lang = 'en', mixed $default = null): mixed
    {
        return $this->get("website.{$key}", $default, $lang);
    }

    /**
     * Get discover features with optimized caching and language support
     */
    public function getDiscoverFeatures(?string $languageCode = null): array
    {
        return $this->get('features.discover_of_features', [], $languageCode);
    }

    /**
     * Clear all caches
     */
    public function clearCache(): void
    {
        self::$cachedSettings = null;

        // Clear cache for all languages
        $languages = Setting::getAvailableLanguages();
        if (is_array($languages)) {
            foreach ($languages as $lang) {
                Cache::forget($this->cacheKey($lang));
            }
        }
    }

    /**
     * Preload all settings into memory cache for all languages
     */
    public function preload(): void
    {
        $languages = Setting::getAvailableLanguages();
        if (is_array($languages)) {
            foreach ($languages as $lang) {
                $this->all($lang);
            }
        }
    }

    /**
     * Get all available languages from settings
     */
    public function getAvailableLanguages(): array
    {
        return Setting::getAvailableLanguages();
    }

    /**
     * Get settings for all languages in a group
     */
    public function getAllLanguagesGroup(string $group): array
    {
        return Setting::getAllLanguagesGroup($group);
    }

    /**
     * Get website settings for all languages
     */
    public function getAllLanguagesWebsiteSettings(): array
    {
        return $this->getAllLanguagesGroup('website');
    }

    /**
     * Get features for all languages
     */
    public function getAllLanguagesFeatures(): array
    {
        return $this->getAllLanguagesGroup('features');
    }

    /**
     * Check if a language is available in settings
     */
    public function isLanguageAvailable(string $languageCode): bool
    {
        return in_array($languageCode, $this->getAvailableLanguages());
    }

    /**
     * Get setting with fallback to default language
     */
    public function getWithFallback(string $path, mixed $default = null, ?string $languageCode = null): mixed
    {
        $languageCode = $languageCode ?? app()->getLocale();

        // Try to get the setting in the requested language
        $value = $this->get($path, null, $languageCode);

        // If not found and not English, try English as fallback
        if ($value === null && $languageCode !== 'en') {
            $value = $this->get($path, $default, 'en');
        }

        return $value ?? $default;
    }

    private function cast(?string $val, string $type): mixed
    {
        return match ($type) {
            'int'   => (int) $val,
            'bool'  => filter_var($val, FILTER_VALIDATE_BOOLEAN) ?? false,
            'json'  => $val ? json_decode($val, true) : null,
            'float' => (float) $val,
            default => $val,
        };
    }
}
