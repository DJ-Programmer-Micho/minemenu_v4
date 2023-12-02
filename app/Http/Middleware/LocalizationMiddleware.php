<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\BusinessController;
use App\Models\Subscription;

class LocalizationMiddleware
{
    public $selectedLanguages = ['en','ar','ku','de','it','fr','es'];
    
    public function handle($request, Closure $next)
    {
        // Check if the URL has the "business_name" parameter
        if ($request->route('business_name')) {
            // Get the user's filtered languages based on the "business_name"
            $businessName = $request->route('business_name');
            // Find the user based on the "business_name"
            // GENERAL DATA
            $userProfile = User::where('name', $businessName)->first();

            // If User Subscription Where Expire
            // $suspended_user_type_1 = Subscription::where('user_id', $userProfile->id)->where('expire_at', '>=', now())->count() > 0;
            $suspended_user_type_1 = $userProfile->status;

            if($suspended_user_type_1 == 0){
                return new RedirectResponse('/suspend_state');
            }
            $activation = Subscription::where('user_id', $userProfile->id)->where('expire_at', '>=', now())->count() > 0;
            if(!$activation){
                return new RedirectResponse('/expire_state');
            }
            App::instance('userProfile', $userProfile);
    
            // If the user does not exist, redirect to the home page
            if (!$businessName) {
                return new RedirectResponse('/'); // Replace '/' with the URL of your home page
            }
    
            // Get the user settings based on the "user_id"
            $userSettings = Setting::where('user_id', $userProfile->id)->first();
            App::instance('userSettings', $userSettings);
            // If the user has settings, retrieve the languages
            if ($userSettings) {
                $this->selectedLanguages = $userSettings->languages;
            }
        }

        if (Str::startsWith($request->route()->uri(), 'rest')) {
            $userProfile = Auth::id();
            // If the user does not exist, redirect to the home page
            if (!$userProfile) {
                return new RedirectResponse('/'); // Replace '/' with the URL of your home page
            }
            // Get the user settings based on the "user_id"
            $userSettings = Setting::where('user_id', $userProfile)->first();

            // If the user has settings, retrieve the languages
            if ($userSettings) {
                $this->selectedLanguages = $userSettings->languages;
            }
        } 
        // If the "business_name" parameter is not present or the user has no specific language preferences
        // Check if the selected locale is supported, otherwise use the fallback language
        if (empty($selectedLanguages)) {
            $selectedLanguages = ['en']; // Fallback languages
        }
    
        // Set the application locale for the current request
        App::setLocale($selectedLanguages[0]);

        if ($request->session()->has('applocale')) {
            App::setLocale($request->session()->get('applocale'));
        } else {
            if($userSettings->languages)
            {
                App::setLocale($userSettings->languages[0]);
            } else {
                App::setLocale(config('translatable.fallback_locale'));
            }
        }
    
        // Get the list of supported locales from the configuration
        $locales = config('translatable.locales', ['en']);
    
        // Get the list of User Selected locales
        $filteredLocales = [];

        // Loop through $this->selectedLanguages and add matching locales to $filteredLocales
        foreach ($this->selectedLanguages as $selectedLanguage) {
            if (in_array($selectedLanguage, $locales)) {
                $filteredLocales[] = $selectedLanguage;
            }
        }

        // Share the variables with all views
        View::share('filteredLocales', $filteredLocales);
        View::share('selectedLocale', $selectedLanguages[0]);
        $request->session()->flash('filteredLocales', $filteredLocales);
    
        return $next($request);
    }
    
        public function setLocale(Request $request)
        {
            $selectedLocale = $request->input('locale');
    
            // Check if the selected locale is supported
            if (in_array($selectedLocale, $this->selectedLanguages)) {
                // Store the selected language in the session
                $request->session()->put('locale', $selectedLocale);
                $request->session()->put('applocale', $selectedLocale);
                // Set the application locale for the current request
                App::setLocale($selectedLocale);
                // dd($selectedLocale);
            }
            return back();
        } // END FUNCTION

        public function setLocaleStartUp(Request $request)
        {
            $selectedLocale = $request->input('locale');
            $businessName = $request->input('businessNameHidden');
    
            // Check if the selected locale is supported
            if (in_array($selectedLocale, $this->selectedLanguages)) {
                // Store the selected language in the session
                $request->session()->put('locale', $selectedLocale);
                $request->session()->put('applocale', $selectedLocale);
                // Set the application locale for the current request
                App::setLocale($selectedLocale);
                
                $request->session()->put('ShutDown', true);
                return new RedirectResponse($businessName);
            }
            return back();
        } // END FUNCTION
}