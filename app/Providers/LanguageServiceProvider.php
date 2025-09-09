<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
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
        // Load admin language files
        $this->loadTranslationsFrom(resource_path('lang/admin'), 'admin');
        
        // Load user language files
        $this->loadTranslationsFrom(resource_path('lang/user'), 'user');
    }
}
