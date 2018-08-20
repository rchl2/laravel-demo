<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Laravel 5.4 key too long error fix
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
