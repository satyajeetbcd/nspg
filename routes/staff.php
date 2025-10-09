<?php

use App\Http\Controllers\Staff\Auth\AuthController;
use App\Http\Controllers\Staff\CountryController;
use App\Http\Controllers\Staff\CustomerController;
use App\Http\Controllers\Staff\DashboardController;
use App\Http\Controllers\Staff\InvoiceController;
use App\Http\Controllers\Staff\PlanController;
use App\Http\Controllers\Staff\ReportsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
|
| These routes are for staff/admin users (users table).
| All routes require staff authentication.
| Format: {locale}/staff/dashboard
|
*/

Route::group([
    'prefix' => '{locale}/staff',
    'middleware' => ['set.locale', 'staff', 'XSS'],
], function () {
    Route::pattern('locale', '[a-z]{2}-[A-Z]{2}');

    /*
    |--------------------------------------------------------------------------
    | Staff Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');
    Route::get('dashboard/health', [DashboardController::class, 'getSystemHealth'])->name('staff.dashboard.health');

    /*
    |--------------------------------------------------------------------------
    | Customer Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('customers')->name('staff.customers.')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('export', 'export')->name('export');
        Route::get('{customer}', 'show')->name('show');
        Route::get('{customer}/edit', 'edit')->name('edit');
        Route::put('{customer}', 'update')->name('update');
        Route::delete('{customer}', 'destroy')->name('destroy');
        Route::post('{customer}/activate', 'activate')->name('activate');
        Route::post('{customer}/deactivate', 'deactivate')->name('deactivate');
        Route::post('{customer}/verify-email', 'verifyEmail')->name('verify-email');
        Route::get('{customer}/assign-plan', 'showAssignPlan')->name('assign-plan');
        Route::post('{customer}/assign-plan', 'assignPlan')->name('assign-plan.store');
        Route::delete('{customer}/remove-plan', 'removePlan')->name('remove-plan');
    });
    /*
    |--------------------------------------------------------------------------
    | Country Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('countries')->name('staff.countries.')->controller(CountryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('export', 'export')->name('export');
        Route::get('{country}', 'show')->name('show');
        Route::get('{country}/edit', 'edit')->name('edit');
        Route::put('{country}', 'update')->name('update');
        Route::delete('{country}', 'destroy')->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Subscription Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('subscriptions')->name('staff.subscriptions.')->controller(\App\Http\Controllers\Staff\SubscriptionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('api/stats', 'getStats')->name('stats');

        // Use explicit action routes to avoid conflicts
        Route::post('action/{subscription}/renew', 'renew')->name('renew')->where('subscription', '[0-9]+');
        Route::post('action/{subscription}/cancel', 'cancel')->name('cancel')->where('subscription', '[0-9]+');
        Route::post('action/{subscription}/extend-grace', 'extendGrace')->name('extend-grace')->where('subscription', '[0-9]+');

        // Standard CRUD routes
        Route::get('{subscription}/edit', 'edit')->name('edit')->where('subscription', '[0-9]+');
        Route::put('{subscription}', 'update')->name('update')->where('subscription', '[0-9]+');
        Route::delete('{subscription}', 'destroy')->name('destroy')->where('subscription', '[0-9]+');
        Route::get('{subscription}', 'show')->name('show')->where('subscription', '[0-9]+');
    });

    /*
    |--------------------------------------------------------------------------
    | Legacy Subscription Routes (Customer-based)
    |--------------------------------------------------------------------------
    */
    Route::prefix('subscription')->name('staff.subscription.')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'subscription')->name('subscription');
        Route::get('/upgrade', 'subscription')->name('upgrade');
        Route::get('/unassign', 'subscription')->name('unassign');
    });

    /*
    |--------------------------------------------------------------------------
    | Invoice Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('invoices')->name('staff.invoices.')->controller(InvoiceController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('{invoice}/edit', 'edit')->name('edit');
        Route::put('{invoice}', 'update')->name('update');
        Route::delete('{invoice}', 'destroy')->name('destroy');
        // Specific action routes must come before the generic {invoice} route
        Route::post('{invoice}/mark-paid', 'markPaid')->name('mark-paid');
        Route::post('{invoice}/mark-pending', 'markPending')->name('mark-pending');
        Route::post('{invoice}/mark-overdue', 'markOverdue')->name('mark-overdue');
        Route::get('{invoice}/download', 'download')->name('download');
        Route::post('{invoice}/send-email', 'sendEmail')->name('send-email');
        Route::get('{invoice}', 'show')->name('show'); // Generic route must be last
    });

    /*
    |--------------------------------------------------------------------------
    | Plan Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('plans')->name('staff.plans.')->controller(PlanController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('{plan}', 'show')->name('show');
        Route::get('edit/{plan}', 'edit')->name('edit');
        Route::post('update/{plan}', 'update')->name('update');
        Route::delete('{plan}', 'destroy')->name('destroy');
        Route::post('{plan}/toggle-visibility', 'toggleVisibility')->name('toggle-visibility');
        Route::post('{plan}/toggle-status', 'toggleStatus')->name('toggle-status');
        Route::get('{plan}/subscribers', 'subscribers')->name('subscribers');
    });

    /*
    |--------------------------------------------------------------------------
    | Reports & Analytics
    |--------------------------------------------------------------------------
    */
    Route::prefix('reports')->name('staff.reports.')->controller(ReportsController::class)->group(function () {
        Route::get('/', 'overview')->name('index');
        Route::get('customers', 'customers')->name('customers');
        Route::get('revenue', 'revenue')->name('revenue');
        Route::get('plans', 'plans')->name('plans');
        Route::get('invoices', 'invoices')->name('invoices');
        Route::get('analytics', 'analytics')->name('analytics');
        Route::get('export', 'export')->name('export');
        Route::get('data', 'getData')->name('data');
    });

    /*
    |--------------------------------------------------------------------------
    | Order Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('orders')->name('staff.orders.')->controller(\App\Http\Controllers\Staff\OrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('pending', 'pending')->name('pending');
        Route::get('paid', 'paid')->name('paid');
        Route::get('export', 'export')->name('export');
        Route::get('api/stats', 'getStats')->name('stats');
        Route::get('{order}', 'show')->name('show');
        Route::post('{order}/accept', 'accept')->name('accept');
        Route::post('{order}/reject', 'reject')->name('reject');
        Route::post('{order}/mark-paid', 'markPaid')->name('mark-paid');
    });

    /*
    |--------------------------------------------------------------------------
    | Staff API Endpoints (AJAX)
    |--------------------------------------------------------------------------
    */
    Route::prefix('api')->name('staff.api.')->group(function () {
        Route::get('dashboard-stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard-stats');
        Route::get('chart-data', [DashboardController::class, 'getChartData'])->name('chart-data');
        Route::get('customers/search', [CustomerController::class, 'search'])->name('customers.search');
        Route::get('customers/stats', [CustomerController::class, 'getStats'])->name('customers.stats');
        Route::get('plans/active', [PlanController::class, 'getActivePlans'])->name('plans.active');
    });
});

/*
|--------------------------------------------------------------------------
| Staff Authentication Routes
|--------------------------------------------------------------------------
| Format: {locale}/staff/login
*/
Route::group([
    'prefix' => '{locale}/staff',
    'middleware' => ['set.locale'],
], function () {
    Route::pattern('locale', '[a-z]{2}-[A-Z]{2}');

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
