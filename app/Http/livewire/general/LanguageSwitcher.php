<?php
 
namespace App\Http\Livewire\general;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Component
{
    public $selectedLanguages;
    public $filteredLocales;
    

    public function mount(Request $request)
    {
        // Set the initial selected language from the session
        
        // $this->selectedLanguage = Session::get('locale', config('app.fallback_locale'));
        $this->selectedLanguages = $request->attributes->get('selectedLanguages');
        $this->filteredLocales = $request->attributes->get('filteredLocales');
    }

    public function switchLanguage($locale)
    {
        // $this->selectedLocale = $request->input('locale');
        // Check if the selected locale is supported
        if (in_array($locale, $this->selectedLanguages)) {
            // Store the selected language in the session
            Session::put('locale', $locale);
            Session::put('applocale', $locale);
            // Set the application locale for the current request
            App::setLocale($locale);


            if (Session::has('applocale')) {
                App::setLocale(Session::get('applocale'));
            } else {
                App::setLocale(config('app.fallback_locale'));
            }
        }
    }

    public function render()
    {
        // dd($this->locale);
        return view('general.livewire.language-switcher', ['filteredLocales' => $this->filteredLocales]);
    }
}