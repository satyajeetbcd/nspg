<?php

namespace Database\Seeders\Tables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data carefully to handle foreign key constraints

        // First, check if plans exist and warn if there are dependencies
        $existingPlans = DB::table('plans')->count();
        if ($existingPlans > 0) {
            $this->command->warn("Found $existingPlans existing plans. Checking for dependencies...");

            // Check for dependencies
            $subscriptions = DB::table('subscription_features')->count();
            $invoices = DB::table('invoices')->where('plan_id', '!=', null)->count();

            if ($subscriptions > 0 || $invoices > 0) {
                $this->command->error("Cannot reseed plans: Found $subscriptions subscription features and $invoices invoices with plan references.");
                $this->command->info("To reseed, you need to manually clean these tables first or use --force flag if implemented.");
                return;
            }
        }

        // Safe to delete in correct order to avoid FK constraints
        DB::table('plan_prices')->delete();
        DB::table('plan_features')->delete();
        DB::table('plan_lang')->delete();
        DB::table('plans')->delete();

        $currentTime = now();

        // Plans data
        $plans = [
            [
                'id' => 1,
                'duration' => 'month',
                'trial' => true,
                'trial_days' => 14,
                'is_disable' => false,
                'is_visible' => true,
                'description' => 'Perfect for small businesses and startups',
                'image' => 'starter-plan.png',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'id' => 2,
                'duration' => 'month',
                'trial' => true,
                'trial_days' => 14,
                'is_disable' => false,
                'is_visible' => true,
                'description' => 'Ideal for growing businesses with more features',
                'image' => 'professional-plan.png',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'id' => 3,
                'duration' => 'month',
                'trial' => true,
                'trial_days' => 30,
                'is_disable' => false,
                'is_visible' => true,
                'description' => 'Complete solution for large enterprises',
                'image' => 'enterprise-plan.png',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'id' => 4,
                'duration' => 'year',
                'trial' => true,
                'trial_days' => 30,
                'is_disable' => false,
                'is_visible' => true,
                'description' => 'Annual starter plan with significant savings',
                'image' => 'starter-annual-plan.png',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'id' => 5,
                'duration' => 'year',
                'trial' => true,
                'trial_days' => 30,
                'is_disable' => false,
                'is_visible' => true,
                'description' => 'Annual professional plan with advanced features',
                'image' => 'professional-annual-plan.png',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'id' => 6,
                'duration' => 'lifetime',
                'trial' => false,
                'trial_days' => null,
                'is_disable' => false,
                'is_visible' => true,
                'description' => 'One-time payment for lifetime access',
                'image' => 'lifetime-plan.png',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];

        // Insert plans
        DB::table('plans')->insert($plans);

        // Plan language translations
        $planLang = [
            // Starter Monthly Plan
            ['plan_id' => 1, 'lang' => 'en', 'name' => 'Starter Monthly', 'description' => 'Perfect for small businesses and startups'],
            ['plan_id' => 1, 'lang' => 'ar', 'name' => 'الخطة الأساسية الشهرية', 'description' => 'مثالية للشركات الصغيرة والناشئة'],

            // Professional Monthly Plan
            ['plan_id' => 2, 'lang' => 'en', 'name' => 'Professional Monthly', 'description' => 'Ideal for growing businesses with more features'],
            ['plan_id' => 2, 'lang' => 'ar', 'name' => 'الخطة المهنية الشهرية', 'description' => 'مثالية للشركات النامية مع المزيد من الميزات'],

            // Enterprise Monthly Plan
            ['plan_id' => 3, 'lang' => 'en', 'name' => 'Enterprise Monthly', 'description' => 'Complete solution for large enterprises'],
            ['plan_id' => 3, 'lang' => 'ar', 'name' => 'الخطة المؤسسية الشهرية', 'description' => 'حل شامل للمؤسسات الكبيرة'],

            // Starter Annual Plan
            ['plan_id' => 4, 'lang' => 'en', 'name' => 'Starter Annual', 'description' => 'Annual starter plan with significant savings'],
            ['plan_id' => 4, 'lang' => 'ar', 'name' => 'الخطة الأساسية السنوية', 'description' => 'خطة أساسية سنوية مع توفير كبير'],

            // Professional Annual Plan
            ['plan_id' => 5, 'lang' => 'en', 'name' => 'Professional Annual', 'description' => 'Annual professional plan with advanced features'],
            ['plan_id' => 5, 'lang' => 'ar', 'name' => 'الخطة المهنية السنوية', 'description' => 'خطة مهنية سنوية مع ميزات متقدمة'],

            // Lifetime Plan
            ['plan_id' => 6, 'lang' => 'en', 'name' => 'Lifetime Access', 'description' => 'One-time payment for lifetime access'],
            ['plan_id' => 6, 'lang' => 'ar', 'name' => 'الوصول مدى الحياة', 'description' => 'دفعة واحدة للوصول مدى الحياة'],
        ];

        // Insert plan languages
        DB::table('plan_lang')->insert($planLang);

        // Plan features
        $planFeatures = [
            // Starter Plan Features
            [
                'id' => 1,
                'plan_id' => 1,
                'max_user' => 5,
                'module_account' => true,
                'module_crm' => false,
                'module_pos' => false,
                'module_hrm' => false,
                'module_project' => false,
                'module_manfucture' => false,
                'more_featrues' => json_encode([
                    'Basic Reports',
                    'Email Support',
                    '1GB Storage',
                    'Basic Invoicing'
                ]),
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            // Professional Plan Features
            [
                'id' => 2,
                'plan_id' => 2,
                'max_user' => 15,
                'module_account' => true,
                'module_crm' => true,
                'module_pos' => true,
                'module_hrm' => false,
                'module_project' => true,
                'module_manfucture' => false,
                'more_featrues' => json_encode([
                    'Advanced Reports',
                    'Priority Support',
                    '10GB Storage',
                    'Advanced Invoicing',
                    'Multi-Currency',
                    'Custom Fields'
                ]),
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            // Enterprise Plan Features
            [
                'id' => 3,
                'plan_id' => 3,
                'max_user' => 100,
                'module_account' => true,
                'module_crm' => true,
                'module_pos' => true,
                'module_hrm' => true,
                'module_project' => true,
                'module_manfucture' => true,
                'more_featrues' => json_encode([
                    'All Reports',
                    '24/7 Phone Support',
                    'Unlimited Storage',
                    'Complete Invoicing Suite',
                    'Multi-Currency',
                    'Custom Fields',
                    'API Access',
                    'White Label',
                    'Custom Integrations',
                    'Dedicated Account Manager'
                ]),
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            // Starter Annual Plan Features (same as monthly but annual)
            [
                'id' => 4,
                'plan_id' => 4,
                'max_user' => 5,
                'module_account' => true,
                'module_crm' => false,
                'module_pos' => false,
                'module_hrm' => false,
                'module_project' => false,
                'module_manfucture' => false,
                'more_featrues' => json_encode([
                    'Basic Reports',
                    'Email Support',
                    '2GB Storage', // Bonus storage for annual
                    'Basic Invoicing',
                    'Annual Discount'
                ]),
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            // Professional Annual Plan Features
            [
                'id' => 5,
                'plan_id' => 5,
                'max_user' => 15,
                'module_account' => true,
                'module_crm' => true,
                'module_pos' => true,
                'module_hrm' => true, // Bonus feature for annual
                'module_project' => true,
                'module_manfucture' => false,
                'more_featrues' => json_encode([
                    'Advanced Reports',
                    'Priority Support',
                    '20GB Storage', // Bonus storage for annual
                    'Advanced Invoicing',
                    'Multi-Currency',
                    'Custom Fields',
                    'Annual Discount'
                ]),
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            // Lifetime Plan Features (all features included)
            [
                'id' => 6,
                'plan_id' => 6,
                'max_user' => 50,
                'module_account' => true,
                'module_crm' => true,
                'module_pos' => true,
                'module_hrm' => true,
                'module_project' => true,
                'module_manfucture' => true,
                'more_featrues' => json_encode([
                    'All Reports',
                    'Priority Support',
                    'Unlimited Storage',
                    'Complete Invoicing Suite',
                    'Multi-Currency',
                    'Custom Fields',
                    'API Access',
                    'Lifetime Updates',
                    'No Recurring Fees'
                ]),
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];

        // Insert plan features
        DB::table('plan_features')->insert($planFeatures);

        // Plan prices for different countries and currencies
        $planPrices = [
            // Starter Monthly Plan Prices
            ['plan_id' => 1, 'country_id' => 1, 'price' => 99.00, 'currency_id' => 1, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Saudi Arabia - SAR
            ['plan_id' => 1, 'country_id' => 2, 'price' => 110.00, 'currency_id' => 2, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UAE - AED
            ['plan_id' => 1, 'country_id' => 3, 'price' => 8.00, 'currency_id' => 3, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Kuwait - KWD
            ['plan_id' => 1, 'country_id' => 13, 'price' => 29.00, 'currency_id' => 13, 'created_at' => $currentTime, 'updated_at' => $currentTime], // USA - USD
            ['plan_id' => 1, 'country_id' => 14, 'price' => 24.00, 'currency_id' => 14, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UK - GBP
            ['plan_id' => 1, 'country_id' => 15, 'price' => 27.00, 'currency_id' => 15, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Germany - EUR

            // Professional Monthly Plan Prices
            ['plan_id' => 2, 'country_id' => 1, 'price' => 199.00, 'currency_id' => 1, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Saudi Arabia - SAR
            ['plan_id' => 2, 'country_id' => 2, 'price' => 220.00, 'currency_id' => 2, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UAE - AED
            ['plan_id' => 2, 'country_id' => 3, 'price' => 16.00, 'currency_id' => 3, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Kuwait - KWD
            ['plan_id' => 2, 'country_id' => 13, 'price' => 59.00, 'currency_id' => 13, 'created_at' => $currentTime, 'updated_at' => $currentTime], // USA - USD
            ['plan_id' => 2, 'country_id' => 14, 'price' => 49.00, 'currency_id' => 14, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UK - GBP
            ['plan_id' => 2, 'country_id' => 15, 'price' => 55.00, 'currency_id' => 15, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Germany - EUR

            // Enterprise Monthly Plan Prices
            ['plan_id' => 3, 'country_id' => 1, 'price' => 399.00, 'currency_id' => 1, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Saudi Arabia - SAR
            ['plan_id' => 3, 'country_id' => 2, 'price' => 440.00, 'currency_id' => 2, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UAE - AED
            ['plan_id' => 3, 'country_id' => 3, 'price' => 32.00, 'currency_id' => 3, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Kuwait - KWD
            ['plan_id' => 3, 'country_id' => 13, 'price' => 119.00, 'currency_id' => 13, 'created_at' => $currentTime, 'updated_at' => $currentTime], // USA - USD
            ['plan_id' => 3, 'country_id' => 14, 'price' => 99.00, 'currency_id' => 14, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UK - GBP
            ['plan_id' => 3, 'country_id' => 15, 'price' => 110.00, 'currency_id' => 15, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Germany - EUR

            // Starter Annual Plan Prices (20% discount)
            ['plan_id' => 4, 'country_id' => 1, 'price' => 950.00, 'currency_id' => 1, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Saudi Arabia - SAR
            ['plan_id' => 4, 'country_id' => 2, 'price' => 1050.00, 'currency_id' => 2, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UAE - AED
            ['plan_id' => 4, 'country_id' => 3, 'price' => 77.00, 'currency_id' => 3, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Kuwait - KWD
            ['plan_id' => 4, 'country_id' => 13, 'price' => 279.00, 'currency_id' => 13, 'created_at' => $currentTime, 'updated_at' => $currentTime], // USA - USD
            ['plan_id' => 4, 'country_id' => 14, 'price' => 230.00, 'currency_id' => 14, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UK - GBP
            ['plan_id' => 4, 'country_id' => 15, 'price' => 259.00, 'currency_id' => 15, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Germany - EUR

            // Professional Annual Plan Prices (20% discount)
            ['plan_id' => 5, 'country_id' => 1, 'price' => 1910.00, 'currency_id' => 1, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Saudi Arabia - SAR
            ['plan_id' => 5, 'country_id' => 2, 'price' => 2110.00, 'currency_id' => 2, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UAE - AED
            ['plan_id' => 5, 'country_id' => 3, 'price' => 154.00, 'currency_id' => 3, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Kuwait - KWD
            ['plan_id' => 5, 'country_id' => 13, 'price' => 567.00, 'currency_id' => 13, 'created_at' => $currentTime, 'updated_at' => $currentTime], // USA - USD
            ['plan_id' => 5, 'country_id' => 14, 'price' => 470.00, 'currency_id' => 14, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UK - GBP
            ['plan_id' => 5, 'country_id' => 15, 'price' => 528.00, 'currency_id' => 15, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Germany - EUR

            // Lifetime Plan Prices
            ['plan_id' => 6, 'country_id' => 1, 'price' => 2999.00, 'currency_id' => 1, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Saudi Arabia - SAR
            ['plan_id' => 6, 'country_id' => 2, 'price' => 3299.00, 'currency_id' => 2, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UAE - AED
            ['plan_id' => 6, 'country_id' => 3, 'price' => 240.00, 'currency_id' => 3, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Kuwait - KWD
            ['plan_id' => 6, 'country_id' => 13, 'price' => 799.00, 'currency_id' => 13, 'created_at' => $currentTime, 'updated_at' => $currentTime], // USA - USD
            ['plan_id' => 6, 'country_id' => 14, 'price' => 649.00, 'currency_id' => 14, 'created_at' => $currentTime, 'updated_at' => $currentTime], // UK - GBP
            ['plan_id' => 6, 'country_id' => 15, 'price' => 729.00, 'currency_id' => 15, 'created_at' => $currentTime, 'updated_at' => $currentTime], // Germany - EUR

            // Additional regional pricing for major markets
            ['plan_id' => 1, 'country_id' => 19, 'price' => 2199.00, 'currency_id' => 19, 'created_at' => $currentTime, 'updated_at' => $currentTime], // India - INR
            ['plan_id' => 2, 'country_id' => 19, 'price' => 4399.00, 'currency_id' => 19, 'created_at' => $currentTime, 'updated_at' => $currentTime], // India - INR
            ['plan_id' => 3, 'country_id' => 19, 'price' => 8799.00, 'currency_id' => 19, 'created_at' => $currentTime, 'updated_at' => $currentTime], // India - INR
        ];

        // Insert plan prices
        DB::table('plan_prices')->insert($planPrices);

        $this->command->info('✅ Plans, features, prices, and language translations seeded successfully!');
        $this->command->info('📊 Seeded:');
        $this->command->info('   • ' . count($plans) . ' plans (Starter, Professional, Enterprise + Annual & Lifetime options)');
        $this->command->info('   • ' . count($planFeatures) . ' plan feature sets');
        $this->command->info('   • ' . count($planPrices) . ' plan prices across multiple countries/currencies');
        $this->command->info('   • ' . count($planLang) . ' plan language translations (EN/AR)');
        $this->command->info('🎯 Features: Account, CRM, POS, HRM, Project, Manufacturing modules');
        $this->command->info('💰 Pricing: GCC, US, EU, and regional markets covered');
    }
}
