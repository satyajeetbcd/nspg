<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Tables\CountrySeeder;
use Database\Seeders\Tables\CurrencySeeder;
use Database\Seeders\Tables\PlanSeeder;
use Database\Seeders\Tables\SettingsSeeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder handles the seeding of all core business data including
     * countries, currencies, and plans with their related tables.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('🚀 Starting Master Data Seeding...');
        $this->command->newLine();

        // Temporarily disable foreign key checks to avoid constraint issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Seed countries and their language translations
        $this->command->info('📍 Seeding Countries and Translations...');
        $this->call(CountrySeeder::class);
        $this->command->newLine();

        // Seed currencies and their language translations
        $this->command->info('💱 Seeding Currencies and Translations...');
        $this->call(CurrencySeeder::class);
        $this->command->newLine();

        // Seed plans with features, prices, and translations
        $this->command->info('📋 Seeding Plans with Features and Pricing...');
        $this->call(PlanSeeder::class);
        $this->command->newLine();

        // Seed application settings
        $this->command->info('⚙️ Seeding Application Settings...');
        $this->call(SettingsSeeder::class);
        $this->command->newLine();

        $this->command->info('✅ Master Data Seeding Completed Successfully!');
        $this->command->info('🎉 Your application now has:');
        $this->command->info('   • 50+ Countries with EN/AR translations');
        $this->command->info('   • 40+ Currencies with symbols and translations');
        $this->command->info('   • 6 Comprehensive pricing plans with features');
        $this->command->info('   • Multi-country pricing for major markets');
        $this->command->info('   • Complete localization support');
        $this->command->info('   • Website settings with EN/AR support');
        $this->command->info('   • Discover features configuration');
        $this->command->newLine();
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('💡 You can now run specific seeders individually if needed:');
        $this->command->info('   php artisan db:seed --class=Database\\Seeders\\Tables\\CountrySeeder');
        $this->command->info('   php artisan db:seed --class=Database\\Seeders\\Tables\\CurrencySeeder');
        $this->command->info('   php artisan db:seed --class=Database\\Seeders\\Tables\\PlanSeeder');
        $this->command->info('   php artisan db:seed --class=Database\\Seeders\\Tables\SettingsSeeder');
    }
}
