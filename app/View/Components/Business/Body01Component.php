<?php

namespace App\View\Components\Business;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Body01Component extends Component
{
    /**
     * Create a new component instance.
     */
    // fixed
    public $glang;
    // Var
    public $setting;
    public $user_id;
    public $rest_name;
    public $ui;
    public $ui_select;

   
    public function __construct($user, $setting, $ui)
    {
        $this->glang = app('glang');
        $this->user_id = $user->id;
        $this->rest_name = $user->name;
        $this->setting = $setting;
        $this->ui = $ui;
        $this->ui_select =  01;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->ui_select == '01') {
            return view('user.components.bodies.body01',[
                'settings' => $this->setting,
                'name' => $this->rest_name,
                'user_id' => $this->user_id,
                'glang' => $this->glang,
                'ui' => $this->ui
            ]);
        }
    }
}
