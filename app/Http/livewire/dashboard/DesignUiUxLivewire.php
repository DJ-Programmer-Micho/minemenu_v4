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
        $ui = json_decode($settings->ui_ux);
        $ui ? $ui : $ui = [01,01,01,01,01,01,01,01];
        $this->selectedDesigns = [
            'navbar' => $ui[0],
            'header' => $ui[1],
            'offer' => $ui[2],
            'menu' => $ui[3],
            'category' => $ui[4],
            'food_list' => $ui[5],
            'food_detail' => $ui[6],
            'offer_detail' => $ui[7],
        ];
    }

    public function saveDesign(){
        $navbarDesign = $this->selectedDesigns['navbar'] ?? '01';
        $headerDesign = $this->selectedDesigns['header'] ?? '01';
        $offerDesign = $this->selectedDesigns['offer'] ?? '01';
        $menuDesign = $this->selectedDesigns['menu'] ?? '01';
        $categoryDesign = $this->selectedDesigns['category'] ?? '01';
        $food_listDesign = $this->selectedDesigns['food_list'] ?? '01';
        $food_detailDesign = $this->selectedDesigns['food_detail'] ?? '01';
        $offer_detailDesign = $this->selectedDesigns['offer_detail'] ?? '01';

        $selectedDesigns = [ $navbarDesign, $headerDesign, $offerDesign, $menuDesign, $categoryDesign, $food_listDesign, $food_detailDesign, $offer_detailDesign];
    
        $selectedDesignString = json_encode($selectedDesigns);


        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $settings->ui_ux = $selectedDesignString;
        $settings->save();



        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);

    }
 
    public function render()
    {
        return view('dashboard.livewire.design-uiux-form');
    }
}

