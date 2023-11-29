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
            if (Auth::user()->role == 1) {
                return ['en']; // Replace "abc" with your desired value or logic to fetch the data.
            } else {
                return Auth::user()->settings->languages; // Replace "abc" with your desired value or logic to fetch the data.
            }
        });
        $this->app->singleton('cloudfront', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/'; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('logo_57', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/app_logo/57.png'; // LOGO 57
        });
        $this->app->singleton('logo_72', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/app_logo/72.png'; // LOGO 72
        });
        $this->app->singleton('logo_114', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/app_logo/114.png'; // LOGO 114
        });
        $this->app->singleton('logo_144', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/app_logo/144.png'; // LOGO 144
        });
        $this->app->singleton('logo_1024', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/app_logo/1024.png'; // LOGO 1024
        });
        $this->app->singleton('logo_144_show', function () {
            return 'mine-setting/app_logo/144.png'; // LOGO 144
        });
        $this->app->singleton('uknown_user', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/user.png'; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('no_uknown_user', function () {
            return 'mine-setting/user.png'; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('fixedimage_640x360', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/defaultimg.jpg'; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('fixedimage_640x360_half', function () {
            return 'mine-setting/defaultimg_cover.jpg'; // Replace "abc" with your desired value or logic to fetch the data.
        });
        $this->app->singleton('fixedvideo_1080x1920', function () {
            return 'https://d3jel9g9x3oq59.cloudfront.net/mine-setting/defaultvideo.mp4'; // Replace "abc" with your desired value or logic to fetch the data.
        });
    }
}
