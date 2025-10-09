<?php

namespace App\Helpers;

use App\Support\Settings;

class WebsiteSettingsHelper
{
    private static ?array $cachedSettings = null;

    public static function getWebsiteSettings(): array
    {
        if (self::$cachedSettings === null) {
            try {
                $settings = app(Settings::class);
                $currentLang = app()->getLocale();
                $contactInfo = [
                    'contact_phone' => [
                        ["type" => "phone", "country" => "Egypt", "value" => "+201023068425", "icon" => "fa-solid fa-phone"],
                        ["type" => "phone", "country" => "Saudi Arabia", "value" => "+966508060608", "icon" => "fa-solid fa-phone"],
                        ["type" => "phone", "country" => "Emirates", "value" => "+971506058635", "icon" => "fa-solid fa-phone"],
                        ["type" => "phone", "country" => "Morroco", "value" => "+212680080175", "icon" => "fa-solid fa-phone"],
                    ],
                    'contact_emails' => [
                        ["type" => "email",  "value" => "info@thefuture-erp.com", "icon" => "fa-solid fa-envelope"],
                        ["type" => "email", "value" => "info@hololtec.com", "icon" => "fa-solid fa-envelope"],
                    ],
                ];
                self::$cachedSettings = [
                    'title' => $settings->getWebsiteSetting('title', $currentLang, 'Future ERP'),
                    'description' => $settings->getWebsiteSetting('description', $currentLang, 'Complete Business Management Solution'),
                    'keywords' => $settings->getWebsiteSetting('keywords', $currentLang, 'ERP, business management'),
                    'address' => $settings->getWebsiteSetting('address', $currentLang, '123 Business Street, City, Country'),
                    'contact_email' => $settings->getWebsiteSetting('contact_email', $currentLang, $contactInfo['contact_emails']),
                    'contact_phone' => $settings->getWebsiteSetting('contact_phone', $currentLang, $contactInfo['contact_phone']),
                    // Social media settings are generic (shared across all languages)
                    'social_media_links' => $settings->getWebsiteSetting('social_media_links', null),
                    // Contact information settings (generic - shared across all languages)
                    'contact_info' => $settings->getWebsiteSetting('contact_info', null),
                ];
            } catch (\Exception $e) {
                // Fallback to default values if settings fail
                self::$cachedSettings = [
                    'title' => 'Future ERP',
                    'description' => 'Complete Business Management Solution',
                    'keywords' => 'ERP, business management',
                    'address' => '123 Business Street, City, Country',
                    'contact_email' => 'info@futureerp.com',
                    'contact_phone' => $contactInfo['contact_phone'],
                    'social_media_links' => [
                        [
                            'platform' => 'facebook',
                            'url' => 'https://www.facebook.com/share/18Li5Y5Lsm/',
                            'icon' => 'fab fa-facebook-f'
                        ],


                        [
                            'platform' => 'instagram',
                            'url' => 'https://www.instagram.com/thefuture.erp/',
                            'icon' => 'fab fa-instagram'
                        ],
                        [
                            'platform' => 'youtube',
                            'url' => 'https://www.youtube.com/@TheFuture-ERP',
                            'icon' => 'fab fa-youtube'
                        ],
                        [
                            'platform' => 'tiktok',
                            'url' => 'https://www.tiktok.com/@thefuture.erp',
                            'icon' => 'fab fa-tiktok'
                        ],
                        [
                            'platform' => 'twitter',
                            'url' => 'https://x.com/ThefutureErp',
                            'icon' => 'fab fa-twitter'
                        ],
                        [
                            'platform' => 'whatsapp',
                            'url' => 'https://wa.me/201023068425',
                            'icon' => 'fab fa-whatsapp'
                        ]
                    ],
                    'contact_info' => [
                        'phones' => [
                            [
                                'country' => 'EGYPT',
                                'phone' => '+201023068425'
                            ],
                            [
                                'country' => 'Saudi Arabia',
                                'phone' => '+966508060608'
                            ],
                            [
                                'country' => 'Emirates',
                                'phone' => '+971506058635'
                            ],
                            [
                                'country' => 'Morroco',
                                'phone' => '+212680080175'
                            ]
                        ],
                        'emails' => [
                            'info@thefuture-erp.com',
                            'info@hololtec.com'
                        ],
                        'addresses' => [
                            'en' => [
                                'Egypt - Cairo - Qalyubia - El-Gomhoria st',
                                'Alexandria - almandara'
                            ],
                            'ar' => [
                                'مصر - القاهرة - القليوبية - شارع الجمهورية',
                                'الإسكندرية - المندرة'
                            ]
                        ]
                    ],
                ];
            }
        }

        return self::$cachedSettings;
    }

    public static function getSetting(string $key, mixed $default = null): mixed
    {
        $settings = self::getWebsiteSettings();
        return $settings[$key] ?? $default;
    }
}
