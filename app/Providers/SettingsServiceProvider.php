<?php

namespace App\Providers;

use App\Support\Settings;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
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
        // Preload settings on application boot for maximum performance
        if (!$this->app->runningInConsole()) {
            $this->app->make(Settings::class)->preload();
        }
    }
}
