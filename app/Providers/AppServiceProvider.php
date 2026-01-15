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
            // In development, cache for only 60 seconds. In production, cache for 1 hour
            $cacheTime = config('app.debug') ? 60 : 3600;
            
            $settings = Cache::remember('site_settings', $cacheTime, function () {
                $settingsData = DB::table('settings')->pluck('value', 'key')->toArray();
                
                return [
                    'site_name' => $settingsData['site_name'] ?? 'AJ Electric',
                    'site_email' => $settingsData['site_email'] ?? 'admin@ajelectric.com',
                    'site_phone' => $settingsData['site_phone'] ?? '+92-300-1234567',
                    'site_whatsapp' => $settingsData['site_whatsapp'] ?? null,
                    'site_address' => $settingsData['site_address'] ?? 'Karachi, Pakistan',
                    'site_logo' => $settingsData['site_logo'] ?? null,
                    'currency_symbol' => $settingsData['currency_symbol'] ?? 'Rs.',
                    'social_facebook' => $settingsData['social_facebook'] ?? null,
                    'social_instagram' => $settingsData['social_instagram'] ?? null,
                    'social_tiktok' => $settingsData['social_tiktok'] ?? null,
                    'social_youtube' => $settingsData['social_youtube'] ?? null,
                    'social_twitter' => $settingsData['social_twitter'] ?? null,
                    'delivery_charges' => $settingsData['delivery_charges'] ?? 250,
                    'bank_name' => $settingsData['bank_name'] ?? null,
                    'account_number' => $settingsData['account_number'] ?? null,
                    'privacy_policy' => $settingsData['privacy_policy'] ?? null,
                    'terms_of_service' => $settingsData['terms_of_service'] ?? null,
                ];
            });
            
            $view->with('siteSettings', (object) $settings);
        });
    }
}
