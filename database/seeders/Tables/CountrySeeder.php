<?php

namespace Database\Seeders\Tables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data in correct order to avoid FK constraints
        DB::table('country_lang')->delete();
        DB::table('country')->delete();

        // Countries data
        $countries = [
            // Middle East & GCC
            ['id' => 1, 'code' => 'SA'],  // Saudi Arabia
            ['id' => 2, 'code' => 'AE'],  // UAE
            ['id' => 3, 'code' => 'KW'],  // Kuwait
            ['id' => 4, 'code' => 'QA'],  // Qatar
            ['id' => 5, 'code' => 'BH'],  // Bahrain
            ['id' => 6, 'code' => 'OM'],  // Oman
            ['id' => 7, 'code' => 'JO'],  // Jordan
            ['id' => 8, 'code' => 'LB'],  // Lebanon
            ['id' => 9, 'code' => 'SY'],  // Syria
            ['id' => 10, 'code' => 'IQ'], // Iraq
            ['id' => 11, 'code' => 'EG'], // Egypt
            ['id' => 12, 'code' => 'YE'], // Yemen

            // Major Global Markets
            ['id' => 13, 'code' => 'US'], // United States
            ['id' => 14, 'code' => 'GB'], // United Kingdom
            ['id' => 15, 'code' => 'DE'], // Germany
            ['id' => 16, 'code' => 'FR'], // France
            ['id' => 17, 'code' => 'CA'], // Canada
            ['id' => 18, 'code' => 'AU'], // Australia
            ['id' => 19, 'code' => 'IN'], // India
            ['id' => 20, 'code' => 'CN'], // China
            ['id' => 21, 'code' => 'JP'], // Japan
            ['id' => 22, 'code' => 'BR'], // Brazil
            ['id' => 23, 'code' => 'MX'], // Mexico
            ['id' => 24, 'code' => 'TR'], // Turkey
            ['id' => 25, 'code' => 'RU'], // Russia

            // Additional African & Asian
            ['id' => 26, 'code' => 'ZA'], // South Africa
            ['id' => 27, 'code' => 'NG'], // Nigeria
            ['id' => 28, 'code' => 'KE'], // Kenya
            ['id' => 29, 'code' => 'SG'], // Singapore
            ['id' => 30, 'code' => 'MY'], // Malaysia
            ['id' => 31, 'code' => 'TH'], // Thailand
            ['id' => 32, 'code' => 'PH'], // Philippines
            ['id' => 33, 'code' => 'ID'], // Indonesia
            ['id' => 34, 'code' => 'VN'], // Vietnam
            ['id' => 35, 'code' => 'KR'], // South Korea

            // European
            ['id' => 36, 'code' => 'IT'], // Italy
            ['id' => 37, 'code' => 'ES'], // Spain
            ['id' => 38, 'code' => 'NL'], // Netherlands
            ['id' => 39, 'code' => 'BE'], // Belgium
            ['id' => 40, 'code' => 'CH'], // Switzerland
            ['id' => 41, 'code' => 'AT'], // Austria
            ['id' => 42, 'code' => 'NO'], // Norway
            ['id' => 43, 'code' => 'SE'], // Sweden
            ['id' => 44, 'code' => 'DK'], // Denmark
            ['id' => 45, 'code' => 'FI'], // Finland
            ['id' => 46, 'code' => 'PL'], // Poland
            ['id' => 47, 'code' => 'CZ'], // Czech Republic
            ['id' => 48, 'code' => 'GR'], // Greece
            ['id' => 49, 'code' => 'PT'], // Portugal
            ['id' => 50, 'code' => 'IE'], // Ireland
        ];

        // Insert countries
        DB::table('country')->insert($countries);

        // Country language translations
        $countryLang = [
            // Saudi Arabia
            ['country_id' => 1, 'lang' => 'en', 'name' => 'Saudi Arabia'],
            ['country_id' => 1, 'lang' => 'ar', 'name' => 'المملكة العربية السعودية'],

            // UAE
            ['country_id' => 2, 'lang' => 'en', 'name' => 'United Arab Emirates'],
            ['country_id' => 2, 'lang' => 'ar', 'name' => 'دولة الإمارات العربية المتحدة'],

            // Kuwait
            ['country_id' => 3, 'lang' => 'en', 'name' => 'Kuwait'],
            ['country_id' => 3, 'lang' => 'ar', 'name' => 'دولة الكويت'],

            // Qatar
            ['country_id' => 4, 'lang' => 'en', 'name' => 'Qatar'],
            ['country_id' => 4, 'lang' => 'ar', 'name' => 'دولة قطر'],

            // Bahrain
            ['country_id' => 5, 'lang' => 'en', 'name' => 'Bahrain'],
            ['country_id' => 5, 'lang' => 'ar', 'name' => 'مملكة البحرين'],

            // Oman
            ['country_id' => 6, 'lang' => 'en', 'name' => 'Oman'],
            ['country_id' => 6, 'lang' => 'ar', 'name' => 'سلطنة عمان'],

            // Jordan
            ['country_id' => 7, 'lang' => 'en', 'name' => 'Jordan'],
            ['country_id' => 7, 'lang' => 'ar', 'name' => 'المملكة الأردنية الهاشمية'],

            // Lebanon
            ['country_id' => 8, 'lang' => 'en', 'name' => 'Lebanon'],
            ['country_id' => 8, 'lang' => 'ar', 'name' => 'الجمهورية اللبنانية'],

            // Syria
            ['country_id' => 9, 'lang' => 'en', 'name' => 'Syria'],
            ['country_id' => 9, 'lang' => 'ar', 'name' => 'الجمهورية العربية السورية'],

            // Iraq
            ['country_id' => 10, 'lang' => 'en', 'name' => 'Iraq'],
            ['country_id' => 10, 'lang' => 'ar', 'name' => 'جمهورية العراق'],

            // Egypt
            ['country_id' => 11, 'lang' => 'en', 'name' => 'Egypt'],
            ['country_id' => 11, 'lang' => 'ar', 'name' => 'جمهورية مصر العربية'],

            // Yemen
            ['country_id' => 12, 'lang' => 'en', 'name' => 'Yemen'],
            ['country_id' => 12, 'lang' => 'ar', 'name' => 'الجمهورية اليمنية'],

            // United States
            ['country_id' => 13, 'lang' => 'en', 'name' => 'United States'],
            ['country_id' => 13, 'lang' => 'ar', 'name' => 'الولايات المتحدة الأمريكية'],

            // United Kingdom
            ['country_id' => 14, 'lang' => 'en', 'name' => 'United Kingdom'],
            ['country_id' => 14, 'lang' => 'ar', 'name' => 'المملكة المتحدة'],

            // Germany
            ['country_id' => 15, 'lang' => 'en', 'name' => 'Germany'],
            ['country_id' => 15, 'lang' => 'ar', 'name' => 'ألمانيا'],

            // France
            ['country_id' => 16, 'lang' => 'en', 'name' => 'France'],
            ['country_id' => 16, 'lang' => 'ar', 'name' => 'فرنسا'],

            // Canada
            ['country_id' => 17, 'lang' => 'en', 'name' => 'Canada'],
            ['country_id' => 17, 'lang' => 'ar', 'name' => 'كندا'],

            // Australia
            ['country_id' => 18, 'lang' => 'en', 'name' => 'Australia'],
            ['country_id' => 18, 'lang' => 'ar', 'name' => 'أستراليا'],

            // India
            ['country_id' => 19, 'lang' => 'en', 'name' => 'India'],
            ['country_id' => 19, 'lang' => 'ar', 'name' => 'الهند'],

            // China
            ['country_id' => 20, 'lang' => 'en', 'name' => 'China'],
            ['country_id' => 20, 'lang' => 'ar', 'name' => 'الصين'],

            // Japan
            ['country_id' => 21, 'lang' => 'en', 'name' => 'Japan'],
            ['country_id' => 21, 'lang' => 'ar', 'name' => 'اليابان'],

            // Brazil
            ['country_id' => 22, 'lang' => 'en', 'name' => 'Brazil'],
            ['country_id' => 22, 'lang' => 'ar', 'name' => 'البرازيل'],

            // Mexico
            ['country_id' => 23, 'lang' => 'en', 'name' => 'Mexico'],
            ['country_id' => 23, 'lang' => 'ar', 'name' => 'المكسيك'],

            // Turkey
            ['country_id' => 24, 'lang' => 'en', 'name' => 'Turkey'],
            ['country_id' => 24, 'lang' => 'ar', 'name' => 'تركيا'],

            // Russia
            ['country_id' => 25, 'lang' => 'en', 'name' => 'Russia'],
            ['country_id' => 25, 'lang' => 'ar', 'name' => 'روسيا'],

            // South Africa
            ['country_id' => 26, 'lang' => 'en', 'name' => 'South Africa'],
            ['country_id' => 26, 'lang' => 'ar', 'name' => 'جنوب أفريقيا'],

            // Nigeria
            ['country_id' => 27, 'lang' => 'en', 'name' => 'Nigeria'],
            ['country_id' => 27, 'lang' => 'ar', 'name' => 'نيجيريا'],

            // Kenya
            ['country_id' => 28, 'lang' => 'en', 'name' => 'Kenya'],
            ['country_id' => 28, 'lang' => 'ar', 'name' => 'كينيا'],

            // Singapore
            ['country_id' => 29, 'lang' => 'en', 'name' => 'Singapore'],
            ['country_id' => 29, 'lang' => 'ar', 'name' => 'سنغافورة'],

            // Malaysia
            ['country_id' => 30, 'lang' => 'en', 'name' => 'Malaysia'],
            ['country_id' => 30, 'lang' => 'ar', 'name' => 'ماليزيا'],

            // Thailand
            ['country_id' => 31, 'lang' => 'en', 'name' => 'Thailand'],
            ['country_id' => 31, 'lang' => 'ar', 'name' => 'تايلاند'],

            // Philippines
            ['country_id' => 32, 'lang' => 'en', 'name' => 'Philippines'],
            ['country_id' => 32, 'lang' => 'ar', 'name' => 'الفلبين'],

            // Indonesia
            ['country_id' => 33, 'lang' => 'en', 'name' => 'Indonesia'],
            ['country_id' => 33, 'lang' => 'ar', 'name' => 'إندونيسيا'],

            // Vietnam
            ['country_id' => 34, 'lang' => 'en', 'name' => 'Vietnam'],
            ['country_id' => 34, 'lang' => 'ar', 'name' => 'فيتنام'],

            // South Korea
            ['country_id' => 35, 'lang' => 'en', 'name' => 'South Korea'],
            ['country_id' => 35, 'lang' => 'ar', 'name' => 'كوريا الجنوبية'],

            // Italy
            ['country_id' => 36, 'lang' => 'en', 'name' => 'Italy'],
            ['country_id' => 36, 'lang' => 'ar', 'name' => 'إيطاليا'],

            // Spain
            ['country_id' => 37, 'lang' => 'en', 'name' => 'Spain'],
            ['country_id' => 37, 'lang' => 'ar', 'name' => 'إسبانيا'],

            // Netherlands
            ['country_id' => 38, 'lang' => 'en', 'name' => 'Netherlands'],
            ['country_id' => 38, 'lang' => 'ar', 'name' => 'هولندا'],

            // Belgium
            ['country_id' => 39, 'lang' => 'en', 'name' => 'Belgium'],
            ['country_id' => 39, 'lang' => 'ar', 'name' => 'بلجيكا'],

            // Switzerland
            ['country_id' => 40, 'lang' => 'en', 'name' => 'Switzerland'],
            ['country_id' => 40, 'lang' => 'ar', 'name' => 'سويسرا'],

            // Austria
            ['country_id' => 41, 'lang' => 'en', 'name' => 'Austria'],
            ['country_id' => 41, 'lang' => 'ar', 'name' => 'النمسا'],

            // Norway
            ['country_id' => 42, 'lang' => 'en', 'name' => 'Norway'],
            ['country_id' => 42, 'lang' => 'ar', 'name' => 'النرويج'],

            // Sweden
            ['country_id' => 43, 'lang' => 'en', 'name' => 'Sweden'],
            ['country_id' => 43, 'lang' => 'ar', 'name' => 'السويد'],

            // Denmark
            ['country_id' => 44, 'lang' => 'en', 'name' => 'Denmark'],
            ['country_id' => 44, 'lang' => 'ar', 'name' => 'الدنمارك'],

            // Finland
            ['country_id' => 45, 'lang' => 'en', 'name' => 'Finland'],
            ['country_id' => 45, 'lang' => 'ar', 'name' => 'فنلندا'],

            // Poland
            ['country_id' => 46, 'lang' => 'en', 'name' => 'Poland'],
            ['country_id' => 46, 'lang' => 'ar', 'name' => 'بولندا'],

            // Czech Republic
            ['country_id' => 47, 'lang' => 'en', 'name' => 'Czech Republic'],
            ['country_id' => 47, 'lang' => 'ar', 'name' => 'جمهورية التشيك'],

            // Greece
            ['country_id' => 48, 'lang' => 'en', 'name' => 'Greece'],
            ['country_id' => 48, 'lang' => 'ar', 'name' => 'اليونان'],

            // Portugal
            ['country_id' => 49, 'lang' => 'en', 'name' => 'Portugal'],
            ['country_id' => 49, 'lang' => 'ar', 'name' => 'البرتغال'],

            // Ireland
            ['country_id' => 50, 'lang' => 'en', 'name' => 'Ireland'],
            ['country_id' => 50, 'lang' => 'ar', 'name' => 'أيرلندا'],
        ];

        // Insert country languages
        DB::table('country_lang')->insert($countryLang);

        $this->command->info('✅ Countries and language translations seeded successfully!');
        $this->command->info('📊 Seeded ' . count($countries) . ' countries with ' . count($countryLang) . ' language translations');
    }
}
