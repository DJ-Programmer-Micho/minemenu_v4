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
        $this->glang = app('glang');
        $this->ui = $ui;
        $this->ui_select = $ui[0];
        $this->settings = $settings;
        $this->setting_name = $settingname;
        // Initialize the categoryData based on menuId
        $this->cartcount = Cart::content()->count();
        $this->initializeFoodData();
    }

    private function initializeFoodData()
    {
        // Implement your data fetching logic using the provided $menuId

        $this->foodData = Food::where('id', $this->detail)->with('translation')->first();
        // $this->foodData = $food->translations->where('lang',  $this->glang )->first();

        // $this->foodData = Food::with(['category', 'translation', 'category.translation' => function ($query) {
        //     $query->where('locale', $this->glang);
        // }, 'translation' => function ($query) {
        //     $query->where('lang', $this->glang);
        // }])
        // ->where('user_id', $this->user->id)
        // ->where('cat_id', $this->detail)
        // ->orderBy('priority', 'ASC')
        // ->first();
        // ->paginate(10);
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
                'cart_count' => $this->cartcount
            ]);
        } else if ($this->ui_select == '02') {
            return view('user.components.details.detail02',[
                'foodData' => $this->foodData, 
                'settings' => $this->settings, 
                'setting_name' => $this->setting_name, 
                'cart_count' => $this->cartcount
            ]);
        } else {
            return view('user.components.details.detail03',[
                'foodData' => $this->foodData, 
                'settings' => $this->settings, 
                'setting_name' => $this->setting_name, 
                'cart_count' => $this->cartcount
            ]);
        }
    }
}
