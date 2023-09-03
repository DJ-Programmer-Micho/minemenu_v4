<?php
 
namespace App\Http\Livewire\dashboard;

use App\Models\Setting;
use Livewire\Component;
 
class DesignUiUxLivewire extends Component
{
    public $lang;
    public $filteredLocales;
    // FormLocal
    public $selectedDesigns = [];

    public function mount()
    {
        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $ui = json_decode($settings->default_lang);
        $this->selectedDesigns = [
            'header' => $ui[0],
            'navbar' => $ui[1],
            'menu' => $ui[2],
        ];
    }

    public function saveDesign(){
        $headerDesign = $this->selectedDesigns['header'] ?? '01';
        $navbarDesign = $this->selectedDesigns['navbar'] ?? '01';
        $menuDesign = $this->selectedDesigns['menu'] ?? '01';

        $selectedDesigns = [$headerDesign, $navbarDesign, $menuDesign];
    
        $selectedDesignString = json_encode($selectedDesigns);


        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $settings->default_lang = $selectedDesignString;
        $settings->save();



        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);

    }
 
    public function render()
    {
        return view('dashboard.livewire.design-uiux-form');
    }
}

