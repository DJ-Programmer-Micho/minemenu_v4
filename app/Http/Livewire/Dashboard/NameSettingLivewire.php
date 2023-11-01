<?php
 
namespace App\Http\Livewire\Dashboard;
 
use Livewire\Component;
use App\Models\Setting;
use App\Models\Setting_Translation;
 
class NameSettingLivewire extends Component
{
    public $lang;
    public $glang;
    public $filteredLocales;
    // FormLocal
    public $namesData = [];
    public $addressData = [];


    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');
        $userId = auth()->id();
        $settings = Setting::where('user_id', $userId)->first();

        if ($settings) {
            foreach ($this->filteredLocales as $locale) {
                $translation = Setting_Translation::where('setting_id', $settings->id)
                    ->where('locale', $locale)
                    ->first();
                if ($translation) {
                    $this->namesData[$locale] = $translation->rest_name;
                    $this->addressData[$locale] = $translation->address;
                } else {
                    $this->namesData[$locale] = 'Not Found';
                    $this->addressData[$locale] = 'Not Found';
                }
                $this->lang = $locale;
            }
        }
    }

    public function saveSettings()
    {
        // $userId = auth()->id();
        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        foreach ($this->filteredLocales as $locale) {
            $translation = [
                'rest_name' => $this->namesData[$locale],
                'address' => $this->addressData[$locale],
            ];
    
            // Use the relation to save or update the translation
            $settings->translations()->updateOrCreate(
                ['locale' => $locale],
                $translation
            );
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);
    }
 
    public function render()
    {
        return view('dashboard.livewire.setting-name-form');
    }
}