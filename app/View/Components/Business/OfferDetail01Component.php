<?php

namespace App\View\Components\Business;

use Closure;
use App\Models\Offer;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Gloudemans\Shoppingcart\Facades\Cart;

class OfferDetail01Component extends Component
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
    public $offerData;
    public $detail;
    public $settings;
    public $setting_name;
    public $cartcount;

    public function __construct($user, $detail, $ui, $settings, $settingname)
    {
        $this->detail = $detail;
        $this->user_id = $user;
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
        $this->offerData = Offer::where('id', $this->detail)->with('translation')->first();
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->ui_select == '01') {
            return view('user.components.offerDetails.offerDetail01',['offerData' => $this->offerData]);
        } else if ($this->ui_select == '02') {
            return view('user.components.offers.offer02');
        } else {
            return view('user.components.offers.offer03');
        }
        
    }
}