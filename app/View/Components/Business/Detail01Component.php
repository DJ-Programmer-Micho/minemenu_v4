<?php

namespace App\View\Components\Business;

use Closure;
use App\Models\Food;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Gloudemans\Shoppingcart\Facades\Cart;

class Detail01Component extends Component
{
    /**
     * Create a new component instance.
     */
    public $detail;
    public $user;
    public $restName;
    public $glang;
    public $foodData;
    public $settings;
    public $setting_name;
    public $ui;
    public $ui_select;
    public $cartcount;


    public function __construct($user, $detail, $ui, $settings, $settingname)
    {
        $this->detail = $detail;
        $this->user = $user;
        $this->restName = $user->name;
        $this->glang = app('glang');
        $this->ui = $ui;
        $this->ui_select = $ui[6] ?? 01;
        $this->settings = $settings;
        $this->setting_name = $settingname;
        // Initialize the categoryData based on menuId
        $this->cartcount = Cart::content()->count();

        $this->initializeFoodData();
        
        // Render the tags in your view
        
    }
    private function initializeFoodData()
    {
        $this->foodData = Food::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        },
        'foodRatings'])
        ->withAvg('foodRatings', 'rating') // Include average rating
        ->withCount('foodRatings') // Include count of reviews
        ->where('id', $this->detail)
        ->where('status', 1)
        ->first();
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->ui_select == '01') {
            return view('user.components.details.detail01',[
                'foodData' => $this->foodData, 
                'settings' => $this->settings, 
                'setting_name' => $this->setting_name, 
                'cart_count' => $this->cartcount,
                'restName' => $this->restName
            ]);
        } else if ($this->ui_select == '02') {
            return view('user.components.details.detail02',[
                'foodData' => $this->foodData, 
                'settings' => $this->settings, 
                'setting_name' => $this->setting_name, 
                'cart_count' => $this->cartcount,
                'restName' => $this->restName
            ]);
        } else if ($this->ui_select == '03') {
            return view('user.components.details.detail03',[
                'foodData' => $this->foodData, 
                'settings' => $this->settings, 
                'setting_name' => $this->setting_name, 
                'cart_count' => $this->cartcount,
                'restName' => $this->restName
            ]);
        } else {
            return view('user.components.details.detail04',[
                'foodData' => $this->foodData, 
                'settings' => $this->settings, 
                'setting_name' => $this->setting_name, 
                'cart_count' => $this->cartcount,
                'restName' => $this->restName
            ]);
        }
    }
}
