<?php
 
namespace App\Http\Livewire\dashboard;

use App\Models\Setting;
use Livewire\Component;
 
class DesignQrLivewire extends Component
{
    public $lang;
    public $filteredLocales;
    // FormLocal
    public $selectedDesigns = [];

    public function mount()
    {
        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $ui = json_decode($settings->ui_ux);
        $ui ? $ui : $ui = [01,02,03,04,05,06];
        $this->selectedDesigns = [
            'header' => $ui[0],
            'navbar' => $ui[1],
            'menu' => $ui[2],
        ];
    }

    public function saveDesign(){
        // $headerDesign = $this->selectedDesigns['header'] ?? '01';
        // $navbarDesign = $this->selectedDesigns['navbar'] ?? '01';
        // $menuDesign = $this->selectedDesigns['menu'] ?? '01';

        // $selectedDesigns = [$headerDesign, $navbarDesign, $menuDesign];
    
        // $selectedDesignString = json_encode($selectedDesigns);


        // $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        // $settings->ui_ux = $selectedDesignString;
        // $settings->save();



        // $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);

    }
 
    public function render()
    {
        return view('dashboard.livewire.design-qr-form');
    }
}

