<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
        View::composer('layouts.app', function ($view) {
            if (Auth::check() && Auth::user()->name === 'ICT') {
                $view->with([
                    'unreadNotificationsCount' => Auth::user()->unreadNotifications()->count(),
                    'latestNotifications' => Auth::user()->notifications()->limit(5)->get(),
                ]);
            }
        });
    }
}
