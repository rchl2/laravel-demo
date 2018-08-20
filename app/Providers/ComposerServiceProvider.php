<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function boot()
    {
        View::composer(
            ['front.home', 'front.pages.*', 'auth.*'],
            'App\Http\ViewComposers\SidebarsComposer'
        );
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }
}
