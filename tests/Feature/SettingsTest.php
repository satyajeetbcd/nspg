<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Support\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_and_retrieve_setting()
    {
        // Create a setting
        Setting::setValue('website', 'title_en', 'Test Title', 'string');

        // Retrieve the setting
        $value = Setting::getValue('website', 'title_en');

        $this->assertEquals('Test Title', $value);
    }

    public function test_can_get_website_setting_with_language()
    {
        // Create settings for both languages
        Setting::setValue('website', 'title_en', 'English Title', 'string');
        Setting::setValue('website', 'title_ar', 'Arabic Title', 'string');

        $settings = app(Settings::class);

        // Test English
        $englishTitle = $settings->getWebsiteSetting('title', 'en');
        $this->assertEquals('English Title', $englishTitle);

        // Test Arabic
        $arabicTitle = $settings->getWebsiteSetting('title', 'ar');
        $this->assertEquals('Arabic Title', $arabicTitle);
    }

    public function test_can_get_discover_features()
    {
        $features = [
            '1' => [
                'discover_icon' => 'fas fa-test',
                'discover_heading' => 'Test Feature',
                'discover_description' => 'Test description'
            ]
        ];

        Setting::setValue('features', 'discover_of_features', $features, 'json');

        $settings = app(Settings::class);
        $retrievedFeatures = $settings->getDiscoverFeatures();

        $this->assertEquals($features, $retrievedFeatures);
    }

    public function test_can_get_all_settings_for_group()
    {
        Setting::setValue('website', 'title_en', 'English Title', 'string');
        Setting::setValue('website', 'title_ar', 'Arabic Title', 'string');
        Setting::setValue('website', 'description_en', 'English Description', 'string');

        $websiteSettings = Setting::getGroup('website');

        $this->assertArrayHasKey('title_en', $websiteSettings);
        $this->assertArrayHasKey('title_ar', $websiteSettings);
        $this->assertArrayHasKey('description_en', $websiteSettings);
        $this->assertEquals('English Title', $websiteSettings['title_en']);
        $this->assertEquals('Arabic Title', $websiteSettings['title_ar']);
        $this->assertEquals('English Description', $websiteSettings['description_en']);
    }

    public function test_setting_casting_works_correctly()
    {
        // Test integer casting
        Setting::setValue('test', 'integer_value', 42, 'int');
        $intValue = Setting::getValue('test', 'integer_value');
        $this->assertIsInt($intValue);
        $this->assertEquals(42, $intValue);

        // Test boolean casting
        Setting::setValue('test', 'boolean_value', true, 'bool');
        $boolValue = Setting::getValue('test', 'boolean_value');
        $this->assertIsBool($boolValue);
        $this->assertTrue($boolValue);

        // Test JSON casting
        $jsonData = ['key' => 'value', 'number' => 123];
        Setting::setValue('test', 'json_value', $jsonData, 'json');
        $jsonValue = Setting::getValue('test', 'json_value');
        $this->assertIsArray($jsonValue);
        $this->assertEquals($jsonData, $jsonValue);

        // Test float casting
        Setting::setValue('test', 'float_value', 3.14, 'float');
        $floatValue = Setting::getValue('test', 'float_value');
        $this->assertIsFloat($floatValue);
        $this->assertEquals(3.14, $floatValue);
    }
}
