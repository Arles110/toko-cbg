<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- WAJIB ADA INI

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
        /**
         * Memaksa Laravel menggunakan HTTPS di server Railway (Production)
         * Ini akan memperbaiki CSS yang hilang dan error saat Logout.
         */
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}