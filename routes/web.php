<?php

use App\Http\Controllers\Shared\RedirectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file contains the core routing logic and redirects.
| Specific functionality is organized in separate route files:
| - routes/public.php (Landing pages, customer auth)
| - routes/customer.php (Customer dashboard)
| - routes/staff.php (Staff/admin panel)
|
*/

/*
|--------------------------------------------------------------------------
| Root Redirects
|--------------------------------------------------------------------------
*/

// Redirect root to default locale home page (XX-XX)
// Route::get('/', function () {
//     return redirect()->route('public.home', ['locale' => config('locale.default', 'en-SA')]);
// });

// // Legacy dashboard redirect for authenticated users (with locale pattern)
// Route::get('{locale}/account-dashboard', [RedirectController::class, 'handle'])
//     ->where('locale', '[a-z]{2}-[A-Z]{2}')
//     ->middleware(['set.locale'])
//     ->name('redirect');

/*
|--------------------------------------------------------------------------
| Health Check & System Routes
|--------------------------------------------------------------------------
*/

Route::get('health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now()->toISOString(),
        'environment' => app()->environment(),
    ]);
})->name('health.check');

Route::get('version', function () {
    return response()->json([
        'application' => config('app.name'),
        'version' => '2.0.0',
        'laravel' => app()->version(),
        'php' => phpversion(),
    ]);
})->name('version');

/*
|--------------------------------------------------------------------------
| Error Pages (Optional)
|--------------------------------------------------------------------------
*/

// Custom 404 page
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

/*
|--------------------------------------------------------------------------
| Development Routes (Only in local environment)
|--------------------------------------------------------------------------
*/

// if (app()->environment('local')) {
//     Route::get('dev/routes', function () {
//         $routes = collect(Route::getRoutes())->map(function ($route) {
//             return [
//                 'method' => implode('|', $route->methods()),
//                 'uri' => $route->uri(),
//                 'name' => $route->getName(),
//                 'action' => $route->getActionName(),
//             ];
//         })->sortBy('uri');

//         return response()->json($routes);
//     })->name('dev.routes');

//     Route::get('dev/config', function () {
//         return response()->json([
//             'guards' => config('auth.guards'),
//             'providers' => config('auth.providers'),
//             'locales' => config('locale'),
//             'mail' => config('mail'),
//         ]);
//     })->name('dev.config');
// }

Route::get('/', [App\Http\Controllers\FrontendController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\FrontendController::class, 'about'])->name('about');
Route::get('/services', [App\Http\Controllers\FrontendController::class, 'services'])->name('services');
Route::get('/board-of-directors', [App\Http\Controllers\FrontendController::class, 'boardOfDirectors'])->name('board-of-directors');
Route::get('/business-and-partnership', [App\Http\Controllers\FrontendController::class, 'businessAndPartnership'])->name('business-and-partnership');
Route::get('/our-clients', [App\Http\Controllers\FrontendController::class, 'ourClients'])->name('our-clients');
Route::get('/download', [App\Http\Controllers\FrontendController::class, 'download'])->name('download');
Route::get('/contact', [App\Http\Controllers\FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [App\Http\Controllers\FrontendController::class, 'submitContactForm'])->name('contact.submit');

// Review routes
Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
Route::get('/api/reviews', [App\Http\Controllers\ReviewController::class, 'getReviews'])->name('api.reviews');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Banner Management
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class);
    Route::post('banners/{banner}/toggle-status', [App\Http\Controllers\Admin\BannerController::class, 'toggleStatus'])->name('banners.toggle-status');
    Route::post('banners/reorder', [App\Http\Controllers\Admin\BannerController::class, 'reorder'])->name('banners.reorder');
    
    // Solar Systems Management
    Route::resource('solar-systems', App\Http\Controllers\Admin\SolarSystemController::class);
    
    // Page Content Management
    Route::resource('page-contents', App\Http\Controllers\Admin\PageContentController::class);
    
    // Contact Info Management
    Route::resource('contact-infos', App\Http\Controllers\Admin\ContactInfoController::class);
    
    // Review Management
    Route::resource('reviews', App\Http\Controllers\Admin\ReviewController::class);
    Route::post('reviews/{review}/toggle-status', [App\Http\Controllers\Admin\ReviewController::class, 'toggleStatus'])->name('reviews.toggle-status');
    Route::post('reviews/{review}/toggle-featured', [App\Http\Controllers\Admin\ReviewController::class, 'toggleFeatured'])->name('reviews.toggle-featured');
    Route::post('reviews/{review}/toggle-verified', [App\Http\Controllers\Admin\ReviewController::class, 'toggleVerified'])->name('reviews.toggle-verified');
    
    // Calculator Management
    Route::resource('calculator', App\Http\Controllers\Admin\CalculatorController::class);
    Route::post('calculator/{setting}/toggle-status', [App\Http\Controllers\Admin\CalculatorController::class, 'toggleStatus'])->name('calculator.toggle-status');
    Route::post('calculator/reset-defaults', [App\Http\Controllers\Admin\CalculatorController::class, 'resetToDefaults'])->name('calculator.reset-defaults');
});

// Admin redirect route
Route::get('/admin', function () {
    return redirect()->route('staff.dashboard', ['locale' => app()->getLocale()]);
})->middleware('staff');
