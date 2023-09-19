<?php

namespace App\View\Components\Business;

use App\Models\Categories;
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
    public $rest_name;
    public $ui;
    public $selected_ui;
    public $cartcount;
    public $setting;
    public $coverid;

    public function __construct($user, $ui, $setting, $coverid)
    {
        $this->setting = $setting;
        $this->rest_name = $user->name;
        $this->user_id = $user->id;
        $this->ui = json_decode($ui);
        $this->selected_ui =  $this->ui[1] ?? 01;
        $this->cartcount = Cart::content()->count();
        $this->coverid = Categories::where('id', $coverid)->first()->cover ?? null;
        // dd($this->coverid);
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->selected_ui == '01') {
            return view('user.components.headers.Header01',[
                'cart_count' => $this->cartcount, 
                'setting' => $this->setting,
                'restName'=> $this->rest_name, 
                'cover_id' => $this->coverid
            ]);
        } else if ($this->selected_ui == '02') {
            return view('user.components.headers.Header02',[
                'cart_count' => $this->cartcount, 
                'setting' => $this->setting,
                'restName'=> $this->rest_name, 
                'cover_id' => $this->coverid
            ]);
        } else {
            return view('user.components.headers.Header03',[
                'cart_count' => $this->cartcount, 
                'setting' => $this->setting,
                'restName'=> $this->rest_name, 
                'cover_id' => $this->coverid
            ]);
        }
    }
}
