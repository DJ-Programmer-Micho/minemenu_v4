<?php

namespace App\View\Components\Business;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class testt01 extends Component
{
    /**
     * Create a new component instance.
     */

     public $sss;

    public function __construct()
    {
        $this->sss = '01';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->sss == '01'){

            return view('components.testt01');
        } else {
            return view('components.testt02');

        }
    }
}
