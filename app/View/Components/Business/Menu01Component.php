<?php

namespace App\View\Components\Business;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Mainmenu;

class Menu01Component extends Component
{
    /**
     * Create a new component instance.
     */
    // fixed
    public $glang;
    // var
    public $user_id;
    public $ui;
    public $ui_select;
    public $setting;

    public function __construct($user, $ui, $settings)
    {
  
        $this->glang = app('glang');
        $this->user_id = $user;
        $this->ui = json_decode($ui);
        $this->ui_select = $this->ui[3] ?? 01;
        $this->setting = $settings;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menuData = Mainmenu::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', $this->user_id )
        ->where('status', 1)
        ->get();
        // ->orderBy('priority', 'ASC')
        // ->paginate(10);

        if ($this->ui_select == '01') {
            return view('user.components.menus.menu01', [
                'menuData' => $menuData,
                'setting' => $this->setting
                ]);
        } else {
            return view('user.components.menus.menu02',[
                'menuData' => $menuData,
                'setting' => $this->setting
                ]);
        }
        
    }
}
