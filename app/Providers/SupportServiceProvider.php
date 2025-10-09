<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Support\Settings;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Settings::class, function () {
            return new Settings(tenantId: null);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
