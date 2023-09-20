<?php

namespace App\View\Components\Business;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CopyRight01Component extends Component
{
    /**
     * Create a new component instance.
     */
    // fixed


    public function __construct()
    {

    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('user.components.copyright.copyright');
    }
}