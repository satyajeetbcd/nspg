<?php

namespace App\Http\Controllers\Public;

use App\Email;
use App\Models\Country;
use App\Models\Plan;
use App\Support\Settings;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    use Email;

    public function __construct()
    {
        $this->initializeEmailConfig();
    }

    /**
     * Show the landing page.
     */
    public function index()
    {
        // Get current language
        $currentLang = app()->getLocale();

        // Get discover features from database settings for current language
        $settings = app(Settings::class);
        $discoverOfFeatures = $settings->getDiscoverFeatures($currentLang);

        // Create global setting object with discover_of_features data
        $globalSetting = (object) [
            'discover_of_features' => collect($discoverOfFeatures)->map(function ($service, $key) {
                return (object) $service;
            })
        ];

        return view('public.home.landing-page', compact('globalSetting'));
    }

    /**
     * Show the contact page.
     */
    public function contact()
    {
        return view('public.home.contact-page');
    }

    /**
     * Handle contact form submission.
     */
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'details' => 'required|string|max:5000',
        ]);

        try {
            $body = view('mail.contact-form', [
                'contactData' => [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'subject' => $request->subject,
                    'details' => $request->details,
                ]
            ])->render();

            // Get contact email from settings
            $settings = app(Settings::class);
            $contactEmail = $settings->getWebsiteSetting('contact_email', app()->getLocale(), env('CONTACT_MAIL_TO', 'admin@example.com'));

            // Create a mock customer object for email sending
            $mockCustomer = (object) [
                'email' => $contactEmail,
                'name' => 'Admin'
            ];

            $this->sendEmail($mockCustomer, 'New Contact Form Submission', $body);

            return redirect()->route('public.contact')
                ->with('success', '✅ Thank you! Your message has been sent successfully.');

        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'name' => $request->name,
                'email' => $request->email
            ]);

            return redirect()->route('public.contact')
                ->with('error', '❌ Sorry, there was an error sending your message. Please try again.');
        }
    }

    /**
     * Show the pricing page.
     */
    public function pricing()
    {
        // Get available plans for the pricing page
        $collection = collect();
        $country = null;
        $currentLanguage = 'en';

        try {
            // Get current locale and determine country
            $currentLocale = session('locale', config('locale.default', 'en-SA'));
            $country = $this->getCountryFromLocale($currentLocale);
            $currentLanguage = substr($currentLocale, 0, 2);

            // Get plans with their prices and features
            if (class_exists(Plan::class)) {
                $collection = Plan::whereNotNull('is_visible')
                    ->with(['prices.currency.currencyLanguages', 'prices.country.countryLanguages', 'features'])
                    ->orderBy('id')
                    ->get();
            }
        } catch (\Exception $e) {
            Log::warning('Could not load plans for pricing page', ['error' => $e->getMessage()]);
        }

        return view('public.home.pricing-page', compact('collection', 'country', 'currentLanguage'));
    }

    /**
     * Get country from locale (e.g., en-SA -> SA)
     */
    private function getCountryFromLocale($locale)
    {
        try {
            // Extract country code from locale (e.g., en-SA -> SA)
            $parts = explode('-', $locale);
            if (count($parts) === 2) {
                $countryCode = $parts[1];
                return Country::where('code', $countryCode)->first();
            }
        } catch (\Exception $e) {
            Log::warning('Could not get country from locale', ['locale' => $locale, 'error' => $e->getMessage()]);
        }

        // Default to SA (Saudi Arabia)
        return Country::where('code', 'SA')->first();
    }


    /**
     * Show dynamic pages (about, terms, privacy, etc.).
     */
    public function page($locale, $slug)
    {
        $validSlugs = ['about', 'privacy', 'terms', 'refund'];

        if (!in_array($slug, $validSlugs)) {
            abort(404);
        }

        // Convert full locale (ar-SA) to short locale (ar) for content directory
        $shortLocale = substr($locale, 0, 2);

        // Try to load content from markdown files
        $contentPath = resource_path("content/{$shortLocale}/{$slug}.md");
        $fallbackContentPath = resource_path("content/en/{$slug}.md");

        $content = '';
        $title = ucfirst($slug);
        $description = '';

        try {
            if (file_exists($contentPath)) {
                $fileContent = file_get_contents($contentPath);
            } elseif (file_exists($fallbackContentPath)) {
                $fileContent = file_get_contents($fallbackContentPath);
            } else {
                // Default content if no markdown file exists
                $html = $this->getDefaultPageContent($slug);
                return view('public.home.dynamic-page', compact('html', 'title', 'description', 'slug'));
            }

            // Parse markdown with front matter
            $object = YamlFrontMatter::parseFile($contentPath ?? $fallbackContentPath);

            $environment = new Environment();
            $environment->addExtension(new CommonMarkCoreExtension());
            $converter = new MarkdownConverter($environment);

            $html = $converter->convert($object->body())->getContent();
            $title = $object->matter('title') ?? ucfirst($slug);
            $description = $object->matter('description') ?? '';

        } catch (\Exception $e) {
            Log::warning("Could not load page content for {$slug}", ['error' => $e->getMessage()]);
            $html = $this->getDefaultPageContent($slug);
        }

        return view('public.home.dynamic-page', compact('html', 'title', 'description', 'slug'));
    }

    /**
     * Get default content for pages when markdown is not available.
     */
    private function getDefaultPageContent($slug)
    {
        $defaultContent = [
            'about' => '<h2>About Us</h2><p>Welcome to our platform. We provide excellent ERP solutions for businesses.</p>',
            'privacy' => '<h2>Privacy Policy</h2><p>Your privacy is important to us. This policy explains how we collect and use your data.</p>',
            'terms' => '<h2>Terms of Service</h2><p>By using our service, you agree to these terms and conditions.</p>',
            'refund' => '<h2>Refund Policy</h2><p>We offer refunds under certain conditions. Please contact support for more information.</p>',
        ];

        return $defaultContent[$slug] ?? '<h2>Page Not Found</h2><p>The requested page content is not available.</p>';
    }
}
