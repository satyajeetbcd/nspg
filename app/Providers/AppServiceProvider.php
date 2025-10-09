<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Lang;
use App\Services\TimezoneService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // App service provider boot logic
        Schema::defaultStringLength(191);

        // Load additional JSON translations for customer panel
        Lang::addJsonPath(resource_path('lang/customer'));

        // Register timezone helper functions
        Blade::directive('userTime', function ($expression) {
            return "<?php echo App\Services\TimezoneService::formatForUser($expression); ?>";
        });

        Blade::directive('userTimezone', function ($expression) {
            return "<?php echo App\Services\TimezoneService::toUserTimezone($expression); ?>";
        });
    }
}
