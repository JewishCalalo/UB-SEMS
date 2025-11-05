<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

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
        if (!extension_loaded('gd')) {
            Log::error('PHP GD extension is missing. DomPDF needs GD to process images. Enable GD in php.ini (e.g., extension=gd) and restart PHP.');
        }
    }
}
