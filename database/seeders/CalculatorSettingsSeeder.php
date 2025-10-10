<?php

namespace Database\Seeders;

use App\Models\CalculatorSetting;
use Illuminate\Database\Seeder;

class CalculatorSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSettings = [
            [
                'setting_key' => 'cost_per_unit',
                'setting_value' => '6',
                'setting_type' => 'number',
                'description' => 'Cost per unit of electricity in ₹',
                'is_active' => true
            ],
            [
                'setting_key' => 'units_per_kw_per_month',
                'setting_value' => '120',
                'setting_type' => 'number',
                'description' => 'Average units generated per kW per month',
                'is_active' => true
            ],
            [
                'setting_key' => 'space_per_kw',
                'setting_value' => '80',
                'setting_type' => 'number',
                'description' => 'Space required per kW in sqft',
                'is_active' => true
            ],
            [
                'setting_key' => 'cost_per_watt',
                'setting_value' => '50',
                'setting_type' => 'number',
                'description' => 'Cost per watt in ₹',
                'is_active' => true
            ],
            [
                'setting_key' => 'subsidy_per_watt',
                'setting_value' => '20',
                'setting_type' => 'number',
                'description' => 'Subsidy per watt in ₹',
                'is_active' => true
            ],
            [
                'setting_key' => 'max_subsidy',
                'setting_value' => '75000',
                'setting_type' => 'number',
                'description' => 'Maximum subsidy amount in ₹',
                'is_active' => true
            ],
            [
                'setting_key' => 'nspg_discount_percentage',
                'setting_value' => '10',
                'setting_type' => 'number',
                'description' => 'NSPG discount percentage',
                'is_active' => true
            ],
            [
                'setting_key' => 'max_nspg_discount',
                'setting_value' => '22000',
                'setting_type' => 'number',
                'description' => 'Maximum NSPG discount in ₹',
                'is_active' => true
            ],
            [
                'setting_key' => 'calculator_title',
                'setting_value' => 'NSPG Solar Calculator',
                'setting_type' => 'text',
                'description' => 'Calculator title',
                'is_active' => true
            ],
            [
                'setting_key' => 'calculator_subtitle',
                'setting_value' => 'Calculate Your Savings',
                'setting_type' => 'text',
                'description' => 'Calculator subtitle',
                'is_active' => true
            ],
            [
                'setting_key' => 'calculator_description',
                'setting_value' => 'Explore the potential of solar energy and start saving from Day One!',
                'setting_type' => 'text',
                'description' => 'Calculator description',
                'is_active' => true
            ],
            [
                'setting_key' => 'cta_button_text',
                'setting_value' => 'Book Free Consultation',
                'setting_type' => 'text',
                'description' => 'Call-to-action button text',
                'is_active' => true
            ],
            [
                'setting_key' => 'is_calculator_enabled',
                'setting_value' => '1',
                'setting_type' => 'boolean',
                'description' => 'Enable/disable calculator on homepage',
                'is_active' => true
            ]
        ];

        foreach ($defaultSettings as $setting) {
            CalculatorSetting::updateOrCreate(
                ['setting_key' => $setting['setting_key']],
                $setting
            );
        }

        $this->command->info('✅ Calculator settings seeded successfully!');
    }
}