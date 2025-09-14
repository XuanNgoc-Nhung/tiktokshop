<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Helpers\TierHelper;
use App\Models\CauHinh;

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
        // Share tiers data to all views
        View::share('tiers', TierHelper::getTiers());
        
        // Share cauHinh data to all views
        View::share('cauHinh', CauHinh::first());
    }
}
