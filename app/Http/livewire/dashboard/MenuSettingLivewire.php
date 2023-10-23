<?php
 
namespace App\Http\Livewire\dashboard;
 
use Livewire\Component;
use App\Models\Setting;
 
class MenuSettingLivewire extends Component
{
    public $glang;
    public $filteredLocales;
    // FormLocal
    public $phone;
    public $wifi;
    public $notes = [];
    public $website;
    public $facebook;
    public $instagram;
    public $telegram;
    public $snapchat;
    public $tiktok;
    public $map;
    public $currency;
    public $fees;
    public $telegram_notify_status;
    public $telegram_notify;


    public function mount()
    {
        $this->glang = app('glang');
        $this->filteredLocales = app('userlanguage');

        $userId = auth()->id();
        $settings = Setting::where('user_id', $userId)->first();
        if ($settings) {
            $this->phone = $settings->phone ? $settings->phone : null ;
            $this->wifi = $settings->wifi ? $settings->wifi : null ;
            $this->website = $settings->website ? $settings->website : null ;
            $this->facebook = $settings->facebook ? $settings->facebook : null ;
            $this->instagram = $settings->instagram ? $settings->instagram : null ;
            $this->telegram = $settings->telegram ? $settings->telegram : null ;
            $this->snapchat = $settings->snapchat ? $settings->snapchat : null ;
            $this->tiktok = $settings->tiktok ? $settings->tiktok : null ;
            $this->map = $settings->map ? $settings->map : null ;
            $this->currency = $settings->currency ? $settings->currency : null ;
            $this->fees = $settings->fees ? $settings->fees : null ;

            $this->telegram_notify_status = $settings->telegram_notify_status ? $settings->telegram_notify_status : null ;
            $this->telegram_notify = $settings->telegram_notify ? $settings->telegram_notify : null ;
    
            $notesData = json_decode($settings->note, true);
    
            foreach ($this->filteredLocales as $locale) {
                $this->notes[$locale] = $notesData[$locale] ?? '';
            }
        }
    }

    public function saveSettings()
    {
        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);

        // Prepare the data for each locale
        $notesData = [];
        if( $this->notes){
            foreach ($this->filteredLocales as $locale) {
                $notesData[$locale] = $this->notes[$locale];
            }
        }
    
        // Convert the notes data array to JSON
        $notesJson = json_encode($notesData);
    
        // Update the settings attributes
        $settings->phone = $this->phone;
        $settings->wifi = $this->wifi;
        $settings->note = $notesJson; // Save the JSON object
        $settings->website = $this->website;
        $settings->facebook = $this->facebook;
        $settings->instagram = $this->instagram;
        $settings->telegram = $this->telegram;
        $settings->snapchat = $this->snapchat;
        $settings->tiktok = $this->tiktok;
        $settings->map = $this->map;
        $settings->currency = $this->currency;
        $settings->fees = $this->fees;
        $settings->telegram_notify_status = $this->telegram_notify_status;
        $settings->telegram_notify = $this->telegram_notify;
    
        $settings->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);
    }
 
    public function render()
    {
        return view('dashboard.livewire.setting-menu-form');
    }
}