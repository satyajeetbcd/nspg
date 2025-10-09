<?php

use App\Http\Middleware\Auth\EnsureAdmin;
use App\Http\Middleware\Auth\EnsureCustomer;
use App\Http\Middleware\Auth\EnsureStaff;
use App\Http\Middleware\Role\CheckUserType;
use App\Http\Middleware\Role\SubscriptionAccess;
use App\Http\Middleware\Security\SetLocale;
use App\Http\Middleware\Security\XSSProtection;
use App\Http\Middleware\StaffAuthenticate;
use App\Http\Middleware\SuperAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(

        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Additional routes are loaded via RouteServiceProvider
            // No additional route loading needed here
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->web(append: [
            SetLocale::class,
        ]);
        $middleware->alias([
            // Localization
            'set.locale' => SetLocale::class,

            // Security
            'XSS' => XSSProtection::class,

            // Authentication
            'customer' => EnsureCustomer::class,
            'staff' => StaffAuthenticate::class,
            'admin' => EnsureAdmin::class,

            // Role-based access
            'user.type' => CheckUserType::class,
            'subscription' => SubscriptionAccess::class,

            // Legacy (to be phased out)
            'isSuperAdmin' => SuperAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //

    })->create();
