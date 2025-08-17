<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        //

        View::composer('*', function ($view) {
            $view->with('boutique_nom', session('boutique_nom'));
            $view->with('boutique_logo', session('boutique_logo'));
            $view->with('boutique_id' , session('boutique_active_id'));
        });
    }
}
