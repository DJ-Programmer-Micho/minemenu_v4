<?php

namespace App\View\Components\Business;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;


class Facilities01Component extends Component
{
    /**
     * Create a new component instance.
     */
    // Var
    public $settingname;
    public $settingaddress;
    public $setting;
    public $filteredlocales;
    public $ui;
    public $ui_select;

   
    public function __construct($settingname, $settingaddress, $filteredlocales, $setting, $ui)
    {
        $this->filteredlocales = $filteredlocales;
        $this->settingname = $settingname;
        $this->settingaddress = $settingaddress;
        $this->setting = $setting;
        $this->ui = json_decode($ui);
        $this->ui_select = $this->ui[0] ?? 01;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->ui_select == '01') {
            return view('user.components.facilities.facility01',[
                'filteredLocales' => $this->filteredlocales,
                'setting' => $this->setting,
                'setting_name' => $this->settingname,
                'setting_address' => $this->settingaddress,
            ]);
        } else if ($this->ui_select == '02') {
            return view('user.components.facilities.facility02',[
                'filteredLocales' => $this->filteredlocales,
                'setting' => $this->setting,
                'setting_name' => $this->settingname,
                'setting_address' => $this->settingaddress,
            ]);
        } else {
            return view('user.components.facilities.facility03',[
                'filteredLocales' => $this->filteredlocales,
                'setting' => $this->setting,
                'setting_name' => $this->settingname,
                'setting_address' => $this->settingaddress,
            ]);
        }
    }
}
