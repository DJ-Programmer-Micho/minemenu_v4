<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;


class LocalizationMainMiddleware
{
    public $selectedLanguages = ['en','ar','ku'];
    
    public function handle($request, Closure $next)
    {
        if (empty($selectedLanguages)) {
            $selectedLanguages = ['en']; // Fallback languages
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
}