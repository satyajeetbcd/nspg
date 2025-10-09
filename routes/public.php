<?php

use App\Http\Controllers\Public\Auth\CustomerAuthController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Shared\LanguageController;
use App\Http\Controllers\EmailValidationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| These routes are for public pages like landing page, contact, pricing,
| and customer authentication (register/login).
|
*/

// Language switching (outside locale group for global access)
Route::get('change-language/{lang}', [LanguageController::class, 'changeLanguage'])->name('public.change.language');

// Email validation routes (outside locale group for global access)
Route::get('email/validate/{token}', [EmailValidationController::class, 'validateToken'])->name('email.validate');
Route::get('email/check/{token}', [EmailValidationController::class, 'checkToken'])->name('email.check');
Route::get('email/stats', [EmailValidationController::class, 'getStats'])->name('email.stats');

// Localized public routes
Route::group([
    'prefix' => '{locale}',
    'middleware' => ['set.locale'],
], function () {
    Route::pattern('locale', '[a-z]{2}-[A-Z]{2}');

    /*
    |--------------------------------------------------------------------------
    | Public Pages
    |--------------------------------------------------------------------------
    */
    Route::get('/', [HomeController::class, 'index'])->name('public.home');
    Route::get('contact', [HomeController::class, 'contact'])->name('public.contact');
    Route::post('contact', [HomeController::class, 'contactSubmit'])->name('public.contact.submit');
    Route::get('pricing', [HomeController::class, 'pricing'])->name('public.pricing');
    Route::get('pages/{slug}', [HomeController::class, 'page'])
        ->where('slug', 'about|privacy|refund|terms')
        ->name('public.page');

    /*
    |--------------------------------------------------------------------------
    | Customer Authentication
    |--------------------------------------------------------------------------
    */

    // Registration
    Route::get('register', [CustomerAuthController::class, 'showRegistrationForm'])->name('public.register');
    Route::post('register', [CustomerAuthController::class, 'register'])->name('public.register.submit');

    // Login & Logout
    Route::get('login', [CustomerAuthController::class, 'showLoginForm'])->name('public.login');
    Route::post('login', [CustomerAuthController::class, 'login'])->name('public.login.submit');
    Route::get('logout', [CustomerAuthController::class, 'logout'])->name('public.logout');

    // Email Verification
    Route::prefix('email')->group(function () {
        Route::get('notice/verify', [CustomerAuthController::class, 'verificationNotice'])->name('public.verification.notice');
        Route::post('resend', [CustomerAuthController::class, 'resend'])->name('public.verification.resend');
        Route::get('verify/{id}/{hash}', [CustomerAuthController::class, 'verify'])->name('public.verification.verify');
    });

    // Password Reset
    Route::get('forgot-password', [CustomerAuthController::class, 'showLinkRequestForm'])->name('public.password.request');
    Route::post('forgot-password/email', [CustomerAuthController::class, 'forgotPasswordMail'])->name('public.password.email');
    Route::get('forgot-password/reset/{token}', [CustomerAuthController::class, 'resetPasswordForm'])->name('public.password.reset');
    Route::post('forgot-password/reset', [CustomerAuthController::class, 'resetPassword'])->name('public.password.update');
});

// Handle short locale codes (ar, en) and redirect to full locale
Route::get('{shortLocale}', function ($shortLocale) {
    $localeMap = [
        'ar' => 'ar-SA',
        'en' => 'en-SA',
    ];

    if (isset($localeMap[$shortLocale])) {
        return redirect()->route('public.home', ['locale' => $localeMap[$shortLocale]]);
    }

    // If not a recognized short locale, fall through to 404
    abort(404);
})->where('shortLocale', 'ar|en');

// Handle short locale with paths
Route::get('{shortLocale}/{path}', function ($shortLocale, $path) {
    $localeMap = [
        'ar' => 'ar-SA',
        'en' => 'en-SA',
    ];

    if (isset($localeMap[$shortLocale])) {
        // Preserve query parameters when redirecting
        $queryString = request()->getQueryString();
        $newUrl = '/' . $localeMap[$shortLocale] . '/' . $path;
        if ($queryString) {
            $newUrl .= '?' . $queryString;
        }
        return redirect($newUrl);
    }

    abort(404);
})->where('shortLocale', 'ar|en')->where('path', '.*');

// Root redirect to default locale
Route::get('/', function () {
    return redirect()->route('public.home', ['locale' => config('locale.default', 'en-SA')]);
});

// Legacy customer redirect (for backward compatibility)
Route::get('customer/{locale}/{path}', function ($locale, $path) {
    return redirect()->route('customer.dashboard', ['locale' => $locale]);
})->where('path', '.*');

// Specific legacy customer routes without locale prefix - redirect to default locale
Route::get('customer/orders/{order}/cancel', function ($order) {
    $defaultLocale = config('locale.default', 'en-SA');
    return redirect('/' . $defaultLocale . '/customer/orders/' . $order . '/cancel');
});

Route::get('customer/orders/{order}', function ($order) {
    $defaultLocale = config('locale.default', 'en-SA');
    return redirect('/' . $defaultLocale . '/customer/orders/' . $order);
});

Route::get('customer/orders', function () {
    $defaultLocale = config('locale.default', 'en-SA');
    return redirect('/' . $defaultLocale . '/customer/orders');
});
