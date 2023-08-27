<?php

namespace App\View\Components\Business;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header01Component extends Component
{
    /**
     * Create a new component instance.
     */
    //var
    public $user_id;
    public $ui;

    public function __construct($user, $ui)
    {
        $this->user_id = $user->id;
        $this->ui = $ui[1];
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->ui == '01') {
            return view('user.components.headers.Header01');
        } else if ($this->ui == '02') {
            return view('user.components.headers.Header02');
        } else {
            return view('user.components.headers.Header03');
        }
    }
}
