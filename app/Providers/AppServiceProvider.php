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
        View::composer('layouts.student', function ($view) {
            $notifications = Auth::check() ? Auth::user()->student->notifications()->whereNull('read_at')->get() : [];
            $view->with('notifications', $notifications);
        });

        View::composer('layouts.company', function ($view) {
            $notifications = Auth::check() ? Auth::user()->company->notifications()->whereNull('read_at')->get() : [];
            $view->with('notifications', $notifications);
        });
    }

}
