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
    public $default_cover;
    public $default_cover_link;

    public function __construct($user, $ui, $setting, $coverid)
    {
        $this->setting = $setting;
        $this->rest_name = $user->name;
        $this->user_id = $user->id;
        $this->ui = json_decode($ui);
        $this->selected_ui =  $this->ui[1] ?? 01;
        $this->cartcount = Cart::content()->count();
        $this->coverid = Categories::where('id', $coverid)->first()->cover ?? null;
        if(empty($this->coverid)) {
            $this->coverid = null;
        }
        $this->default_cover = app('fixedimage_640x360_half');
        $this->default_cover_link = app('cloudfront');

        // $bgImage = $this->coverid ?? $this->setting->background_img_header ?? $this->default_cover;
        // dd($bgImage);
        // dd($this->coverid);
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->selected_ui == '01') {
            return view('user.components.headers.header01',[
                'cart_count' => $this->cartcount, 
                'setting' => $this->setting,
                'restName'=> $this->rest_name, 
                'cover_id' => $this->coverid,
                'default_cover' => $this->default_cover,
                'default_cover_link' => $this->default_cover_link
            ]);
        } else if ($this->selected_ui == '02') {
            return view('user.components.headers.header02',[
                'cart_count' => $this->cartcount, 
                'setting' => $this->setting,
                'restName'=> $this->rest_name, 
                'cover_id' => $this->coverid,
                'default_cover' => $this->default_cover,
                'default_cover_link' => $this->default_cover_link
            ]);
        } else {
            return view('user.components.headers.header03',[
                'cart_count' => $this->cartcount, 
                'setting' => $this->setting,
                'restName'=> $this->rest_name, 
                'cover_id' => $this->coverid,
                'default_cover' => $this->default_cover,
                'default_cover_link' => $this->default_cover_link
            ]);
        }
    }
}
