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

class LocalizationMiddleware
{
    public $selectedLanguages = ['en', 'ar', 'ku', 'it'];

    public function handle($request, Closure $next)
    {
        // Check if the URL has the "business_name" parameter
        if ($request->route('business_name')) {
            // Get the user's filtered languages based on the "business_name"
            $businessName = $request->route('business_name');
    
            // Find the user based on the "business_name"
            $userProfile = User::where('name', $businessName)->first();
    
            // If the user does not exist, redirect to the home page
            if (!$businessName) {
                return new RedirectResponse('/'); // Replace '/' with the URL of your home page
            }
    
            // Get the user settings based on the "user_id"
            $userSettings = Setting::where('user_id', $userProfile->id)->first();
            
            // If the user has settings, retrieve the languages
            if ($userSettings) {
                $this->selectedLanguages = $userSettings->languages;
                // $this->selectedLanguages = json_decode($userSettings->languages, true);
                // dd($this->selectedLanguages);
            }
        }

        if (Str::startsWith($request->route()->uri(), 'rest/')) {
  
            $userProfile = User::where('id', Auth::id())->first();
    
            // If the user does not exist, redirect to the home page
            if (!$userProfile) {
                return new RedirectResponse('/'); // Replace '/' with the URL of your home page
            }
    
            // Get the user settings based on the "user_id"
            $userSettings = Setting::where('user_id', $userProfile->id)->first();
            
            // If the user has settings, retrieve the languages
            if ($userSettings) {
                $this->selectedLanguages = $userSettings->languages;
                // $this->selectedLanguages = json_decode($userSettings->languages, true);
                // dd($this->selectedLanguages);
            }
        } 

        // If the "business_name" parameter is not present or the user has no specific language preferences
        // Check if the selected locale is supported, otherwise use the fallback language
        if (empty($selectedLanguages)) {
            $selectedLanguages = ['en', 'ar', 'ku']; // Fallback languages
        }
    
        // Set the application locale for the current request
        App::setLocale($selectedLanguages[0]);

        if ($request->session()->has('applocale')) {
            App::setLocale($request->session()->get('applocale'));
        } else {
            App::setLocale(config('app.fallback_locale'));
        }
    
        // Get the list of supported locales from the configuration
        $locales = config('translatable.locales', ['en']);
    
        // Get the list of User Selected locales
        $filteredLocales = array_intersect($locales, $this->selectedLanguages);
    
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
}