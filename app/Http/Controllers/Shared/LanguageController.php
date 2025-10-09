<?php

namespace App\Http\Controllers\Shared;

use App\Models\Customer;
use App\Models\Language;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    /**
     * Change the current language for the user or session.
     * Updates SITE_RTL setting for RTL languages.
     */
    public function changeLanguage($lang, Request $request)
    {
        // Map language codes to full locales
        $languageToLocaleMap = [
            'en' => 'en-SA',
            'ar' => 'ar-SA',
        ];

        // If we receive a short code, convert it to full locale
        if (strlen($lang) === 2 && isset($languageToLocaleMap[$lang])) {
            $normalizedLang = $languageToLocaleMap[$lang];
        } else {
            // Convert language code format (e.g., ar_SA to ar-SA)
            $normalizedLang = str_replace('_', '-', $lang);
        }

        // Enforce XX-XX format and validate that the language is supported
        $supportedLocales = config('locale.supported', ['en-SA', 'ar-SA']);
        if (!preg_match('/^[a-z]{2}-[A-Z]{2}$/', $normalizedLang)) {
            $normalizedLang = config('locale.default', 'en-SA');
        }
        if (!in_array($normalizedLang, $supportedLocales)) {
            $normalizedLang = config('locale.default', 'en-SA');
        }

        // Extract the base language code for App::setLocale (e.g., ar-SA to ar)
        $baseLang = explode('-', $normalizedLang)[0];

        // Change locale
        App::setLocale($baseLang);
        Session::put('locale', $normalizedLang);

        // Get the return path from query parameter or current path
        $returnTo = $request->query('return_to');

        if ($returnTo) {
            // Check if return_to is just a locale (home page case)
            if (preg_match('/^[a-z]{2}-[A-Z]{2}$/', $returnTo)) {
                // This is the home page, redirect to home with new locale
                return redirect()->route('public.home', ['locale' => $normalizedLang])
                    ->with('success', __('Language changed successfully.'));
            }

            // Remove the current locale from the return path if it exists
            $pathWithoutLocale = preg_replace('/^[a-z]{2}-[A-Z]{2}\//', '', $returnTo);

            // If path is just the root after removing locale, redirect to home
            if (empty($pathWithoutLocale) || $pathWithoutLocale === '/') {
                return redirect()->route('public.home', ['locale' => $normalizedLang])
                    ->with('success', __('Language changed successfully.'));
            }

            // Redirect to the same page with new locale
            $newUrl = url($normalizedLang . '/' . ltrim($pathWithoutLocale, '/'));
            return redirect($newUrl)->with('success', __('Language changed successfully.'));
        }

        // Fallback: Get the current path and clean it
        $currentPath = request()->path();
        $pathWithoutLocale = preg_replace('/^[a-z]{2}-[A-Z]{2}\//', '', $currentPath);

        // Special handling for change-language route - redirect to home
        if (strpos($pathWithoutLocale, 'change-language/') === 0) {
            return redirect()->route('public.home', ['locale' => $normalizedLang])
                ->with('success', __('Language changed successfully.'));
        }

        // If path is just the root after removing locale, redirect to home
        if (empty($pathWithoutLocale) || $pathWithoutLocale === '/') {
            return redirect()->route('public.home', ['locale' => $normalizedLang])
                ->with('success', __('Language changed successfully.'));
        }

        // For other paths, try to maintain the current route
        $newUrl = url($normalizedLang . '/' . ltrim($pathWithoutLocale, '/'));

        return redirect($newUrl)->with('success', __('Language changed successfully.'));
    }

    /**
     * Manage language labels and messages.
     * Only accessible by super admin.
     */
    public function manageLanguage($currantLang)
    {
        // Check if user is authenticated and is super admin
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('staff.login', ['locale' => app()->getLocale()])
                ->with('error', 'Please log in to access this page.');
        }

        $user = Auth::guard('staff')->user();
        if (!$this->isSuperAdmin($user)) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $languages = Language::pluck('full_name', 'code');
        $settings = app(\App\Support\Settings::class)->all();

        $disabledLang = [];
        if (!empty($settings['disable_lang'])) {
            $disabledLang = explode(',', $settings['disable_lang']);
        }

        $dir = base_path() . '/resources/lang/' . $currantLang;
        if (!is_dir($dir)) {
            $dir = base_path() . '/resources/lang/en';
        }

        $arrLabel = json_decode(file_get_contents($dir . '.json'), true) ?? [];
        $arrFiles = array_diff(scandir($dir), ['.', '..']);
        $arrMessage = [];

        foreach ($arrFiles as $file) {
            $fileName = basename($file, ".php");
            $fileData = include $dir . "/" . $file;
            if (is_array($fileData)) {
                $arrMessage[$fileName] = $fileData;
            }
        }

        return view('staff.language.index', compact(
            'languages', 'currantLang', 'arrLabel', 'arrMessage', 'disabledLang', 'settings'
        ));
    }

    /**
     * Store language data (labels/messages) for a language.
     * Only accessible by super admin.
     */
    public function storeLanguageData(Request $request, $currantLang)
    {
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('staff.login', ['locale' => app()->getLocale()]);
        }

        $user = Auth::guard('staff')->user();
        if (!$this->isSuperAdmin($user)) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $Filesystem = new Filesystem();
        $dir = base_path() . '/resources/lang/';

        if (!is_dir($dir)) {
            mkdir($dir);
            chmod($dir, 0777);
        }

        $jsonFile = $dir . "/" . $currantLang . ".json";

        if (isset($request->label) && !empty($request->label)) {
            file_put_contents($jsonFile, json_encode($request->label));
        }

        $langFolder = $dir . "/" . $currantLang;

        if (!is_dir($langFolder)) {
            mkdir($langFolder);
            chmod($langFolder, 0777);
        }

        if (isset($request->message) && !empty($request->message)) {
            foreach ($request->message as $fileName => $fileData) {
                $content = "<?php return [";
                $content .= $this->buildArray($fileData);
                $content .= "];";
                file_put_contents($langFolder . "/" . $fileName . '.php', $content);
            }
        }

        return redirect()->route('staff.language.manage', [$currantLang])
            ->with('success', __('Language saved successfully.'));
    }

    /**
     * Helper to build PHP array string from language messages.
     */
    private function buildArray($fileData)
    {
        $content = "";
        foreach ($fileData as $label => $data) {
            if (is_array($data)) {
                $content .= "'$label'=>[" . $this->buildArray($data) . "],";
            } else {
                $content .= "'$label'=>'" . addslashes($data) . "',";
            }
        }

        return $content;
    }

    /**
     * Check if user is a super admin.
     */
    private function isSuperAdmin($user): bool
    {
        return (
            (isset($user->type) && $user->type === 'super admin') ||
            (isset($user->role) && $user->role === 'super_admin') ||
            (isset($user->is_super_admin) && $user->is_super_admin) ||
            (method_exists($user, 'hasRole') && $user->hasRole('super_admin'))
        );
    }
}


