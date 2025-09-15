<?php

namespace App\Providers;

use App\Models\Suggestion;
use Auth;
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

        View::composer('*', function ($view) {

            $fk_boutique = session('boutique_active_id');
            $notifications_non_lues = Suggestion::where('fk_boutique', $fk_boutique)
                ->where('direction', 'admin')
                ->where('type_operation', 'notification')
                ->where('status', 'attente')
                ->whereYear('created_at' , now()->year)
                ->count();

            $view->with('notifications_non_lues', $notifications_non_lues);
        });

        View::composer('*' , function($view){
            $suggestions_attentes = Suggestion::where('type_operation' , 'suggestion')
            ->where('direction', 'superadmin')
            ->where('status', 'attente')
            ->whereYear('created_at' , now()->year)
            ->count();

            $view->with('suggestions_attentes', $suggestions_attentes);
        });

        View::composer('*' , function($view){
            $notifications_attentes = Suggestion::where('type_operation' , 'notification')
            ->where('direction', 'superadmin')
            ->where('status', 'attente')
            ->whereYear('created_at' , now()->year)
            ->count();

            $view->with('notifications_attentes', $notifications_attentes);
        });
    }
}
