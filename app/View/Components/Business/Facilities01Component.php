<?php

namespace App\View\Components\Business;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Facilities01Component extends Component
{
    /**
     * Create a new component instance.
     */
    // Var
    public $settingname;
    public $setting;
    public $filteredlocales;
    public $ui;
    public $ui_select;

   
    public function __construct($settingname, $filteredlocales, $setting, $ui)
    {
        $this->filteredlocales = $filteredlocales;
        $this->settingname = $settingname;
        $this->setting = $setting;
        $this->ui = $ui;
        $this->ui_select = $ui[0];
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
            ]);
        } else if ($this->ui_select == '02') {
            return view('user.components.facilities.facility01',[
                'filteredLocales' => $this->filteredlocales,
                'setting_name' => $this->settingname,
            ]);
        } else {
            return view('user.components.facilities.facility01',[
                'filteredLocales' => $this->filteredlocales,
                'setting_name' => $this->settingname,
            ]);
        }
    }
}
