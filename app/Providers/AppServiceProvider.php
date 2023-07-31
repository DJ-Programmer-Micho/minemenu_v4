<?php

namespace App\Providers;

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
    }
}
