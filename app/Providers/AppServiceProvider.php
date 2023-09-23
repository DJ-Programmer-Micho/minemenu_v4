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
        $this->app->singleton('uknown_user', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/user.png'; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('fixedimage_640x360', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/defaultimg.jpg'; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('fixedimage_640x360_half', function () {
            return 'mine-setting/defaultimg.jpg'; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('fixedvideo_1080x1920', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/defaultvideo.mp4'; // Replace "abc" with your desired value or logic to fetch the data.
        });
    }
}
