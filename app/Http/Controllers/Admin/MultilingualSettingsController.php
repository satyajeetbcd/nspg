<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Support\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MultilingualSettingsController extends Controller
{
    protected $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Display multilingual settings management page
     */
    public function index()
    {
        $languages = Language::all();
        $availableLanguages = $this->settings->getAvailableLanguages();

        // Get all website settings for all languages
        $websiteSettings = $this->settings->getAllLanguagesWebsiteSettings();

        // Get all features for all languages
        $featuresSettings = $this->settings->getAllLanguagesFeatures();

        return view('admin.settings.multilingual', compact(
            'languages',
            'availableLanguages',
            'websiteSettings',
            'featuresSettings'
        ));
    }

    /**
     * Update website settings for a specific language
     */
    public function updateWebsiteSettings(Request $request, string $languageCode)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'keywords' => 'required|string|max:500',
        ]);

        $this->settings->set('website', 'title', $request->title, 'string', $languageCode);
        $this->settings->set('website', 'description', $request->description, 'string', $languageCode);
        $this->settings->set('website', 'keywords', $request->keywords, 'string', $languageCode);

        return redirect()->back()->with('success', "Website settings updated for {$languageCode} language.");
    }

    /**
     * Update features settings for a specific language
     */
    public function updateFeaturesSettings(Request $request, string $languageCode)
    {
        $features = $request->input('features', []);

        // Validate features structure
        foreach ($features as $key => $feature) {
            if (!isset($feature['discover_heading']) || !isset($feature['discover_description'])) {
                return redirect()->back()->with('error', 'Invalid feature structure.');
            }
        }

        $this->settings->set('features', 'discover_of_features', $features, 'json', $languageCode);

        return redirect()->back()->with('success', "Features settings updated for {$languageCode} language.");
    }

    /**
     * Get settings for a specific language via AJAX
     */
    public function getLanguageSettings(string $languageCode)
    {
        $websiteSettings = $this->settings->get('website', null, $languageCode);
        $featuresSettings = $this->settings->get('features', null, $languageCode);

        return response()->json([
            'website' => $websiteSettings,
            'features' => $featuresSettings,
        ]);
    }

    /**
     * Add a new language to settings
     */
    public function addLanguage(Request $request)
    {
        $request->validate([
            'language_code' => 'required|string|size:2',
            'copy_from' => 'required|string|size:2',
        ]);

        $languageCode = $request->language_code;
        $copyFrom = $request->copy_from;

        // Check if language already exists in settings
        if ($this->settings->isLanguageAvailable($languageCode)) {
            return redirect()->back()->with('error', 'Language already exists in settings.');
        }

        // Copy all settings from source language
        $allSettings = $this->settings->all($copyFrom);

        foreach ($allSettings as $group => $settings) {
            foreach ($settings as $key => $value) {
                $this->settings->set($group, $key, $value, null, $languageCode);
            }
        }

        return redirect()->back()->with('success', "Language {$languageCode} added successfully with settings copied from {$copyFrom}.");
    }

    /**
     * Remove a language from settings
     */
    public function removeLanguage(string $languageCode)
    {
        if ($languageCode === 'en') {
            return redirect()->back()->with('error', 'Cannot remove default English language.');
        }

        // Remove all settings for this language
        \App\Models\Setting::where('language_code', $languageCode)->delete();

        return redirect()->back()->with('success', "Language {$languageCode} removed successfully.");
    }
}
