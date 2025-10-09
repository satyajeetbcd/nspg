<?php

use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\InvoiceController;
use App\Http\Controllers\Customer\PlanRequestController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
| These routes are for authenticated customers (customers table).
| All routes require customer authentication.
| Format: {locale}/customer/dashboard
|
*/

Route::group([
    'prefix' => '{locale}/customer',
    'middleware' => ['set.locale', 'customer', 'XSS'],
], function () {
    Route::pattern('locale', '[a-z]{2}-[A-Z]{2}');

    /*
    |--------------------------------------------------------------------------
    | Customer Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('dashboard/stats', [DashboardController::class, 'getStats'])->name('customer.dashboard.stats');
    Route::get('dashboard/plan-info', [DashboardController::class, 'getPlanTimeInfo'])->name('customer.dashboard.plan-info');

    /*
    |--------------------------------------------------------------------------
    | Customer Profile Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->name('customer.profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update/{customer}', 'update')->name('update');
        Route::post('submit/{customer}', 'update')->name('submit');
        Route::post('password', 'updatePassword')->name('password');
        Route::delete('avatar', 'deleteAvatar')->name('avatar.delete');
        Route::get('export', 'exportData')->name('export');
        Route::get('completion', 'getCompletionPercentage')->name('completion');
    });

    /*
    |--------------------------------------------------------------------------
    | Customer Subscription Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('subscription')->name('customer.subscription.')->controller(SubscriptionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('plans', 'availablePlans')->name('plans');
        Route::get('billing', 'billing')->name('billing');
        Route::get('history', 'history')->name('history');
        Route::get('upgrade/{plan}', 'showUpgrade')->name('upgrade.show');
        Route::post('upgrade/{plan}', 'upgrade')->name('upgrade');
        Route::post('cancel', 'cancel')->name('cancel');
        Route::get('invoice/{invoice}', 'invoice')->name('invoice');
    });

    /*
    |--------------------------------------------------------------------------
    | Customer Invoices
    |--------------------------------------------------------------------------
    */
    Route::prefix('invoices')->name('customer.invoices.')->controller(InvoiceController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('history', 'history')->name('history');
        Route::get('{invoice}/download', 'download')->name('download');
        Route::post('{invoice}/pay', 'pay')->name('pay');
        Route::get('{invoice}', 'show')->name('show');
    });

    // Single invoice route (for backward compatibility)
    Route::get('invoice', [InvoiceController::class, 'index'])->name('customer.invoice');

    /*
    |--------------------------------------------------------------------------
    | Customer Plan Requests & Orders
    |--------------------------------------------------------------------------
    */
    Route::prefix('plan-requests')->name('customer.plan-requests.')->controller(PlanRequestController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

    Route::prefix('orders')->name('customer.orders.')->controller(PlanRequestController::class)->group(function () {
        Route::get('/', 'orders')->name('index');
        Route::get('{order}', 'show')->name('show');
        Route::delete('{order}/cancel', 'cancel')->name('cancel');
        Route::post('{order}/payment', 'processPayment')->name('payment');
    });

    /*
    |--------------------------------------------------------------------------
    | Customer API Endpoints (AJAX)
    |--------------------------------------------------------------------------
    */
    Route::prefix('api')->name('customer.api.')->group(function () {
        Route::get('notifications', function () {
            return response()->json(['notifications' => []]);
        })->name('notifications');

        Route::get('quick-stats', function () {
            $customer = auth()->guard('customer')->user();
            return response()->json([
                'invoices_count' => $customer->invoices()->count(),
                'pending_payments' => $customer->invoices()->where('status', 'pending')->count(),
                'plan_status' => $customer->getPlan ? 'active' : 'no_plan',
            ]);
        })->name('quick-stats');
    });
});
