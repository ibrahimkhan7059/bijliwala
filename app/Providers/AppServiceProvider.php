<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
        // Share settings with all views
        View::composer('*', function ($view) {
            $settings = Cache::remember('site_settings', 3600, function () {
                $settingsData = DB::table('settings')->pluck('value', 'key')->toArray();
                
                return [
                    'site_name' => $settingsData['site_name'] ?? 'AJ Electric',
                    'site_email' => $settingsData['site_email'] ?? 'admin@ajelectric.com',
                    'site_phone' => $settingsData['site_phone'] ?? '+92-300-1234567',
                    'site_address' => $settingsData['site_address'] ?? 'Karachi, Pakistan',
                    'site_logo' => $settingsData['site_logo'] ?? null,
                    'currency_symbol' => $settingsData['currency_symbol'] ?? 'Rs.',
                    'social_facebook' => $settingsData['social_facebook'] ?? null,
                    'social_instagram' => $settingsData['social_instagram'] ?? null,
                    'social_tiktok' => $settingsData['social_tiktok'] ?? null,
                    'delivery_charges' => $settingsData['delivery_charges'] ?? 250,
                    'bank_name' => $settingsData['bank_name'] ?? null,
                    'account_number' => $settingsData['account_number'] ?? null,
                ];
            });
            
            $view->with('siteSettings', (object) $settings);
        });
    }
}
