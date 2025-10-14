<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Plan;
use App\Support\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {


        // Share only essential global data
        View::composer('*', function ($view) {
            $languages = cache()->remember('languages.list', 3600, function () {
                return Language::get()->pluck('full_name', 'code')->toArray();
            });

            // Create locale mapping for language switcher
            $localeMap = [
                'en' => 'en-US',
              
            ];

            $view->with([
                'languages' => $languages,
               
            ]);

            // Admin-specific variables
            if (Auth::check() && Auth::user()->type == 'super admin') {
                $view->with([
                    'userPlan' => Plan::getPlan(Auth::user()?->id),
                    'user' => Auth::user(),
                ]);
            }
        });


        // Share default values for views that previously used settings
        View::composer(['layouts.landingpage.*', 'layouts.master', 'home.*'], function ($view) {
            $view->with([
                'siteLogo' => 'logo.png',
                'companyFavicon' => 'favicon.ico',
                'customColor' => '#0061ae',
            ]);
        });
    }
}
