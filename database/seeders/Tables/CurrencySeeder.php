<?php

namespace Database\Seeders\Tables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data in correct order to avoid FK constraints
        DB::table('currency_lang')->delete();
        DB::table('currency')->delete();

        // Currency data with country mappings
        // Each country gets a unique currency_id, even if they use the same currency
        $currencies = [
            // GCC & Middle East
            ['id' => 1, 'country_id' => 1, 'currency_id' => 1],  // Saudi Arabia -> SAR
            ['id' => 2, 'country_id' => 2, 'currency_id' => 2],  // UAE -> AED
            ['id' => 3, 'country_id' => 3, 'currency_id' => 3],  // Kuwait -> KWD
            ['id' => 4, 'country_id' => 4, 'currency_id' => 4],  // Qatar -> QAR
            ['id' => 5, 'country_id' => 5, 'currency_id' => 5],  // Bahrain -> BHD
            ['id' => 6, 'country_id' => 6, 'currency_id' => 6],  // Oman -> OMR
            ['id' => 7, 'country_id' => 7, 'currency_id' => 7],  // Jordan -> JOD
            ['id' => 8, 'country_id' => 8, 'currency_id' => 8],  // Lebanon -> LBP
            ['id' => 9, 'country_id' => 9, 'currency_id' => 9],  // Syria -> SYP
            ['id' => 10, 'country_id' => 10, 'currency_id' => 10], // Iraq -> IQD
            ['id' => 11, 'country_id' => 11, 'currency_id' => 11], // Egypt -> EGP
            ['id' => 12, 'country_id' => 12, 'currency_id' => 12], // Yemen -> YER

            // Major Global Markets
            ['id' => 13, 'country_id' => 13, 'currency_id' => 13], // United States -> USD
            ['id' => 14, 'country_id' => 14, 'currency_id' => 14], // United Kingdom -> GBP
            ['id' => 15, 'country_id' => 15, 'currency_id' => 15], // Germany -> EUR
            ['id' => 16, 'country_id' => 16, 'currency_id' => 16], // France -> EUR (unique ID)
            ['id' => 17, 'country_id' => 17, 'currency_id' => 17], // Canada -> CAD
            ['id' => 18, 'country_id' => 18, 'currency_id' => 18], // Australia -> AUD
            ['id' => 19, 'country_id' => 19, 'currency_id' => 19], // India -> INR
            ['id' => 20, 'country_id' => 20, 'currency_id' => 20], // China -> CNY
            ['id' => 21, 'country_id' => 21, 'currency_id' => 21], // Japan -> JPY
            ['id' => 22, 'country_id' => 22, 'currency_id' => 22], // Brazil -> BRL
            ['id' => 23, 'country_id' => 23, 'currency_id' => 23], // Mexico -> MXN
            ['id' => 24, 'country_id' => 24, 'currency_id' => 24], // Turkey -> TRY
            ['id' => 25, 'country_id' => 25, 'currency_id' => 25], // Russia -> RUB

            // Additional African & Asian
            ['id' => 26, 'country_id' => 26, 'currency_id' => 26], // South Africa -> ZAR
            ['id' => 27, 'country_id' => 27, 'currency_id' => 27], // Nigeria -> NGN
            ['id' => 28, 'country_id' => 28, 'currency_id' => 28], // Kenya -> KES
            ['id' => 29, 'country_id' => 29, 'currency_id' => 29], // Singapore -> SGD
            ['id' => 30, 'country_id' => 30, 'currency_id' => 30], // Malaysia -> MYR
            ['id' => 31, 'country_id' => 31, 'currency_id' => 31], // Thailand -> THB
            ['id' => 32, 'country_id' => 32, 'currency_id' => 32], // Philippines -> PHP
            ['id' => 33, 'country_id' => 33, 'currency_id' => 33], // Indonesia -> IDR
            ['id' => 34, 'country_id' => 34, 'currency_id' => 34], // Vietnam -> VND
            ['id' => 35, 'country_id' => 35, 'currency_id' => 35], // South Korea -> KRW

            // European (EUR zone) - each gets unique currency_id
            ['id' => 36, 'country_id' => 36, 'currency_id' => 36], // Italy -> EUR
            ['id' => 37, 'country_id' => 37, 'currency_id' => 37], // Spain -> EUR
            ['id' => 38, 'country_id' => 38, 'currency_id' => 38], // Netherlands -> EUR
            ['id' => 39, 'country_id' => 39, 'currency_id' => 39], // Belgium -> EUR
            ['id' => 40, 'country_id' => 40, 'currency_id' => 40], // Switzerland -> CHF
            ['id' => 41, 'country_id' => 41, 'currency_id' => 41], // Austria -> EUR
            ['id' => 42, 'country_id' => 42, 'currency_id' => 42], // Norway -> NOK
            ['id' => 43, 'country_id' => 43, 'currency_id' => 43], // Sweden -> SEK
            ['id' => 44, 'country_id' => 44, 'currency_id' => 44], // Denmark -> DKK
            ['id' => 45, 'country_id' => 45, 'currency_id' => 45], // Finland -> EUR
            ['id' => 46, 'country_id' => 46, 'currency_id' => 46], // Poland -> PLN
            ['id' => 47, 'country_id' => 47, 'currency_id' => 47], // Czech Republic -> CZK
            ['id' => 48, 'country_id' => 48, 'currency_id' => 48], // Greece -> EUR
            ['id' => 49, 'country_id' => 49, 'currency_id' => 49], // Portugal -> EUR
            ['id' => 50, 'country_id' => 50, 'currency_id' => 50], // Ireland -> EUR
        ];

        // Insert currency mappings
        DB::table('currency')->insert($currencies);

        // Currency language translations
        $currencyLang = [
            // SAR - Saudi Riyal
            ['currency_id' => 1, 'lang' => 'en', 'name' => 'Saudi Riyal', 'symbol' => 'SR'],
            ['currency_id' => 1, 'lang' => 'ar', 'name' => 'ريال سعودي', 'symbol' => 'ر.س'],

            // AED - UAE Dirham
            ['currency_id' => 2, 'lang' => 'en', 'name' => 'UAE Dirham', 'symbol' => 'AED'],
            ['currency_id' => 2, 'lang' => 'ar', 'name' => 'درهم إماراتي', 'symbol' => 'د.إ'],

            // KWD - Kuwaiti Dinar
            ['currency_id' => 3, 'lang' => 'en', 'name' => 'Kuwaiti Dinar', 'symbol' => 'KD'],
            ['currency_id' => 3, 'lang' => 'ar', 'name' => 'دينار كويتي', 'symbol' => 'د.ك'],

            // QAR - Qatari Riyal
            ['currency_id' => 4, 'lang' => 'en', 'name' => 'Qatari Riyal', 'symbol' => 'QR'],
            ['currency_id' => 4, 'lang' => 'ar', 'name' => 'ريال قطري', 'symbol' => 'ر.ق'],

            // BHD - Bahraini Dinar
            ['currency_id' => 5, 'lang' => 'en', 'name' => 'Bahraini Dinar', 'symbol' => 'BD'],
            ['currency_id' => 5, 'lang' => 'ar', 'name' => 'دينار بحريني', 'symbol' => 'د.ب'],

            // OMR - Omani Rial
            ['currency_id' => 6, 'lang' => 'en', 'name' => 'Omani Rial', 'symbol' => 'OR'],
            ['currency_id' => 6, 'lang' => 'ar', 'name' => 'ريال عماني', 'symbol' => 'ر.ع'],

            // JOD - Jordanian Dinar
            ['currency_id' => 7, 'lang' => 'en', 'name' => 'Jordanian Dinar', 'symbol' => 'JD'],
            ['currency_id' => 7, 'lang' => 'ar', 'name' => 'دينار أردني', 'symbol' => 'د.أ'],

            // LBP - Lebanese Pound
            ['currency_id' => 8, 'lang' => 'en', 'name' => 'Lebanese Pound', 'symbol' => 'LBP'],
            ['currency_id' => 8, 'lang' => 'ar', 'name' => 'ليرة لبنانية', 'symbol' => 'ل.ل'],

            // SYP - Syrian Pound
            ['currency_id' => 9, 'lang' => 'en', 'name' => 'Syrian Pound', 'symbol' => 'SYP'],
            ['currency_id' => 9, 'lang' => 'ar', 'name' => 'ليرة سورية', 'symbol' => 'ل.س'],

            // IQD - Iraqi Dinar
            ['currency_id' => 10, 'lang' => 'en', 'name' => 'Iraqi Dinar', 'symbol' => 'IQD'],
            ['currency_id' => 10, 'lang' => 'ar', 'name' => 'دينار عراقي', 'symbol' => 'د.ع'],

            // EGP - Egyptian Pound
            ['currency_id' => 11, 'lang' => 'en', 'name' => 'Egyptian Pound', 'symbol' => 'EGP'],
            ['currency_id' => 11, 'lang' => 'ar', 'name' => 'جنيه مصري', 'symbol' => 'ج.م'],

            // YER - Yemeni Rial
            ['currency_id' => 12, 'lang' => 'en', 'name' => 'Yemeni Rial', 'symbol' => 'YER'],
            ['currency_id' => 12, 'lang' => 'ar', 'name' => 'ريال يمني', 'symbol' => 'ر.ي'],

            // USD - US Dollar
            ['currency_id' => 13, 'lang' => 'en', 'name' => 'US Dollar', 'symbol' => '$'],
            ['currency_id' => 13, 'lang' => 'ar', 'name' => 'دولار أمريكي', 'symbol' => '$'],

            // GBP - British Pound
            ['currency_id' => 14, 'lang' => 'en', 'name' => 'British Pound', 'symbol' => '£'],
            ['currency_id' => 14, 'lang' => 'ar', 'name' => 'جنيه إسترليني', 'symbol' => '£'],

            // EUR - Euro (Germany)
            ['currency_id' => 15, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 15, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],

            // EUR - Euro (France)
            ['currency_id' => 16, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 16, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],

            // CAD - Canadian Dollar
            ['currency_id' => 17, 'lang' => 'en', 'name' => 'Canadian Dollar', 'symbol' => 'CAD'],
            ['currency_id' => 17, 'lang' => 'ar', 'name' => 'دولار كندي', 'symbol' => 'CAD'],

            // AUD - Australian Dollar
            ['currency_id' => 18, 'lang' => 'en', 'name' => 'Australian Dollar', 'symbol' => 'AUD'],
            ['currency_id' => 18, 'lang' => 'ar', 'name' => 'دولار أسترالي', 'symbol' => 'AUD'],

            // INR - Indian Rupee
            ['currency_id' => 19, 'lang' => 'en', 'name' => 'Indian Rupee', 'symbol' => '₹'],
            ['currency_id' => 19, 'lang' => 'ar', 'name' => 'روبية هندية', 'symbol' => '₹'],

            // CNY - Chinese Yuan
            ['currency_id' => 20, 'lang' => 'en', 'name' => 'Chinese Yuan', 'symbol' => '¥'],
            ['currency_id' => 20, 'lang' => 'ar', 'name' => 'يوان صيني', 'symbol' => '¥'],

            // JPY - Japanese Yen
            ['currency_id' => 21, 'lang' => 'en', 'name' => 'Japanese Yen', 'symbol' => '¥'],
            ['currency_id' => 21, 'lang' => 'ar', 'name' => 'ين ياباني', 'symbol' => '¥'],

            // BRL - Brazilian Real
            ['currency_id' => 22, 'lang' => 'en', 'name' => 'Brazilian Real', 'symbol' => 'R$'],
            ['currency_id' => 22, 'lang' => 'ar', 'name' => 'ريال برازيلي', 'symbol' => 'R$'],

            // MXN - Mexican Peso
            ['currency_id' => 23, 'lang' => 'en', 'name' => 'Mexican Peso', 'symbol' => 'MXN'],
            ['currency_id' => 23, 'lang' => 'ar', 'name' => 'بيزو مكسيكي', 'symbol' => 'MXN'],

            // TRY - Turkish Lira
            ['currency_id' => 24, 'lang' => 'en', 'name' => 'Turkish Lira', 'symbol' => '₺'],
            ['currency_id' => 24, 'lang' => 'ar', 'name' => 'ليرة تركية', 'symbol' => '₺'],

            // RUB - Russian Ruble
            ['currency_id' => 25, 'lang' => 'en', 'name' => 'Russian Ruble', 'symbol' => '₽'],
            ['currency_id' => 25, 'lang' => 'ar', 'name' => 'روبل روسي', 'symbol' => '₽'],

            // ZAR - South African Rand
            ['currency_id' => 26, 'lang' => 'en', 'name' => 'South African Rand', 'symbol' => 'R'],
            ['currency_id' => 26, 'lang' => 'ar', 'name' => 'راند جنوب أفريقي', 'symbol' => 'R'],

            // NGN - Nigerian Naira
            ['currency_id' => 27, 'lang' => 'en', 'name' => 'Nigerian Naira', 'symbol' => '₦'],
            ['currency_id' => 27, 'lang' => 'ar', 'name' => 'نايرا نيجيري', 'symbol' => '₦'],

            // KES - Kenyan Shilling
            ['currency_id' => 28, 'lang' => 'en', 'name' => 'Kenyan Shilling', 'symbol' => 'KSh'],
            ['currency_id' => 28, 'lang' => 'ar', 'name' => 'شلن كيني', 'symbol' => 'KSh'],

            // SGD - Singapore Dollar
            ['currency_id' => 29, 'lang' => 'en', 'name' => 'Singapore Dollar', 'symbol' => 'SGD'],
            ['currency_id' => 29, 'lang' => 'ar', 'name' => 'دولار سنغافوري', 'symbol' => 'SGD'],

            // MYR - Malaysian Ringgit
            ['currency_id' => 30, 'lang' => 'en', 'name' => 'Malaysian Ringgit', 'symbol' => 'RM'],
            ['currency_id' => 30, 'lang' => 'ar', 'name' => 'رينغيت ماليزي', 'symbol' => 'RM'],

            // THB - Thai Baht
            ['currency_id' => 31, 'lang' => 'en', 'name' => 'Thai Baht', 'symbol' => '฿'],
            ['currency_id' => 31, 'lang' => 'ar', 'name' => 'بات تايلاندي', 'symbol' => '฿'],

            // PHP - Philippine Peso
            ['currency_id' => 32, 'lang' => 'en', 'name' => 'Philippine Peso', 'symbol' => '₱'],
            ['currency_id' => 32, 'lang' => 'ar', 'name' => 'بيزو فلبيني', 'symbol' => '₱'],

            // IDR - Indonesian Rupiah
            ['currency_id' => 33, 'lang' => 'en', 'name' => 'Indonesian Rupiah', 'symbol' => 'Rp'],
            ['currency_id' => 33, 'lang' => 'ar', 'name' => 'روبية إندونيسية', 'symbol' => 'Rp'],

            // VND - Vietnamese Dong
            ['currency_id' => 34, 'lang' => 'en', 'name' => 'Vietnamese Dong', 'symbol' => '₫'],
            ['currency_id' => 34, 'lang' => 'ar', 'name' => 'دونغ فيتنامي', 'symbol' => '₫'],

            // KRW - South Korean Won
            ['currency_id' => 35, 'lang' => 'en', 'name' => 'South Korean Won', 'symbol' => '₩'],
            ['currency_id' => 35, 'lang' => 'ar', 'name' => 'وون كوري جنوبي', 'symbol' => '₩'],

            // EUR - Euro (Italy)
            ['currency_id' => 36, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 36, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],

            // EUR - Euro (Spain)
            ['currency_id' => 37, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 37, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],

            // EUR - Euro (Netherlands)
            ['currency_id' => 38, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 38, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],

            // EUR - Euro (Belgium)
            ['currency_id' => 39, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 39, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],

            // CHF - Swiss Franc
            ['currency_id' => 40, 'lang' => 'en', 'name' => 'Swiss Franc', 'symbol' => 'CHF'],
            ['currency_id' => 40, 'lang' => 'ar', 'name' => 'فرنك سويسري', 'symbol' => 'CHF'],

            // EUR - Euro (Austria)
            ['currency_id' => 41, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 41, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],

            // NOK - Norwegian Krone
            ['currency_id' => 42, 'lang' => 'en', 'name' => 'Norwegian Krone', 'symbol' => 'kr'],
            ['currency_id' => 42, 'lang' => 'ar', 'name' => 'كرونة نرويجية', 'symbol' => 'kr'],

            // SEK - Swedish Krona
            ['currency_id' => 43, 'lang' => 'en', 'name' => 'Swedish Krona', 'symbol' => 'kr'],
            ['currency_id' => 43, 'lang' => 'ar', 'name' => 'كرونة سويدية', 'symbol' => 'kr'],

            // DKK - Danish Krone
            ['currency_id' => 44, 'lang' => 'en', 'name' => 'Danish Krone', 'symbol' => 'kr'],
            ['currency_id' => 44, 'lang' => 'ar', 'name' => 'كرونة دنماركية', 'symbol' => 'kr'],

            // EUR - Euro (Finland)
            ['currency_id' => 45, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 45, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],

            // PLN - Polish Zloty
            ['currency_id' => 46, 'lang' => 'en', 'name' => 'Polish Zloty', 'symbol' => 'zł'],
            ['currency_id' => 46, 'lang' => 'ar', 'name' => 'زلوتي بولندي', 'symbol' => 'zł'],

            // CZK - Czech Koruna
            ['currency_id' => 47, 'lang' => 'en', 'name' => 'Czech Koruna', 'symbol' => 'Kč'],
            ['currency_id' => 47, 'lang' => 'ar', 'name' => 'كرونة تشيكية', 'symbol' => 'Kč'],

            // EUR - Euro (Greece)
            ['currency_id' => 48, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 48, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],

            // EUR - Euro (Portugal)
            ['currency_id' => 49, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 49, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],

            // EUR - Euro (Ireland)
            ['currency_id' => 50, 'lang' => 'en', 'name' => 'Euro', 'symbol' => '€'],
            ['currency_id' => 50, 'lang' => 'ar', 'name' => 'يورو', 'symbol' => '€'],
        ];

        // Insert currency languages
        DB::table('currency_lang')->insert($currencyLang);

        $this->command->info('✅ Currencies and language translations seeded successfully!');
        $this->command->info('📊 Seeded ' . count($currencies) . ' currency mappings with ' . count($currencyLang) . ' language translations');
        $this->command->info('💰 Currencies include: GCC countries, major global markets, and regional currencies');
    }
}
