<?php
 
namespace App\Http\Livewire\dashboard;

use Livewire\Component;
 
class LanguageSettingLivewire extends Component
{
    public $lang;
    public $filteredLocales;
    // FormLocal
    public $allLanguages = [];
    public $selectedLanguages = [];
    protected $listeners = ['updateSort' => 'handleCroppedImage'];

    public function mount()
    {
        $this->allLanguages = config('translatable.locales');
        $this->filteredLocales = app('userlanguage') ?? [];

        $sortedLanguages = [];
    
        foreach ($this->filteredLocales as $filteredLocale) {
            if (in_array($filteredLocale, $this->allLanguages)) {
                $sortedLanguages[] = $filteredLocale;
            }
        }
    
        // Append any remaining languages that were not in filteredLocales
        foreach ($this->allLanguages as $language) {
            if (!in_array($language, $sortedLanguages)) {
                $sortedLanguages[] = $language;
            }
        }
    
        $this->allLanguages = $sortedLanguages;
    }

    public function handleCroppedImage($list)
    {
        $this->selectedLanguages = $list;
    }
    
    public function saveLanguages()
    {
        $settings = auth()->user()->settings;
        $settings->languages = $this->selectedLanguages;
        $settings->save();

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);
    }
 
    public function render()
    {
        return view('dashboard.livewire.setting-language-form');
    }
}
