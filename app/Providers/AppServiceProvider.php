<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
        // Fetch the Site Settings object and share it with all views
        $this->app->singleton('glang', function () {
            return app()->getLocale(); // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('userlanguage', function () {
            return Auth::user()->settings->languages; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('cloudfront', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/'; // Replace "abc" with your desired value or logic to fetch the data.
        });
    }
}
