<?php

namespace App\View\Components\Business;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class Header01Component extends Component
{
    /**
     * Create a new component instance.
     */
    //var
    public $user_id;
    public $ui;
    public $cartcount;
    public $setting;

    public function __construct($user, $ui, $setting)
    {
        $this->setting = $setting;
        $this->user_id = $user->id;
        $this->ui = $ui[1];
        $this->cartcount = Cart::content()->count();
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->ui == '01') {
            return view('user.components.headers.Header01',['cart_count' => $this->cartcount, 'setting' => $this->setting]);
        } else if ($this->ui == '02') {
            return view('user.components.headers.Header02',['cart_count' => $this->cartcount, 'setting' => $this->setting]);
        } else {
            return view('user.components.headers.Header03',['cart_count' => $this->cartcount, 'setting' => $this->setting]);
        }
    }
}
