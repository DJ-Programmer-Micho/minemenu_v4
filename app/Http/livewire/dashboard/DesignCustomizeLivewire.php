<?php
 
namespace App\Http\Livewire\dashboard;

use App\Models\Setting;
use Livewire\Component;
 
class DesignCustomizeLivewire extends Component
{
    public $lang;
    public $filteredLocales;
    // FormLocal
    public $formFields;
    public $selectedHeader;
    public $selectedHeaderOp;
    public $selectedNavbar;
    public $selectedNavbarOp;
    public $selectedMenu;
    public $selectedMenuOp;

    public function mount()
    {
        // Load color values from the database based on the user's ID
        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $colors = $settings->default_lang ?? null;
    
        // Check if the colors data exists and assign them to Livewire properties
        if ($colors) {
            $this->selectedHeader = $default_lang['selectedHeader'] ?? '#ff0';
            $this->selectedHeaderOp = $default_lang['selectedHeaderOp'] ?? '#766fa8';
            $this->selectedNavbar = $default_lang['selectedNavbar'] ?? '#766fa8';
            $this->selectedNavbarOp = $default_lang['selectedNavbarOp'] ?? '#766fa8';
            $this->selectedMenu = $default_lang['selectedMenu'] ?? '#766fa8';
            $this->selectedMenuOp = $default_lang['selectedMenuOp'] ?? '#766fa8';
        }
    }

 
    public function render()
    {

        return view('dashboard.livewire.design-customize-form');
    }


    public function saveColors(){
        dd($this->selectedColor1);
        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $settings->default_lang = [
            'selectedHeader' => $this->selectedHeader ?? '#766fa8',
            'selectedHeaderOp' => $this->selectedHeaderOp ?? '0.20',
            'selectedNavbar' => $this->selectedNavbar ?? '#766fa8',
            'selectedNavbarOp' => $this->selectedNavbarOp ?? '0.90',
            'selectedMenu' => $this->selectedMenu ?? '#766fa8',
            'selectedMenuOp' => $this->selectedMenuOp ?? '1.0',
        ];
        $settings->save();

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);
    }
}

