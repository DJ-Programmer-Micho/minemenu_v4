<?php
 
namespace App\Http\Livewire\dashboard;

use App\Models\Setting;
use Livewire\Component;
 
class DesignCustomizeLivewire extends Component
{
    public $lang;
    public $filteredLocales;
    // FormLocal
    public $formFields;
    //NAVBAR GROUP
    public $selected_navbar_title;
    public $selected_navbar_toggle;
    public $selected_navbar_top;
    public $selected_navbar_sub_title;
    public $selected_navbar_text;
    public $selected_navbar_top_ground;
    public $selected_navbar_bottom_ground;
    //Main Group
    public $selected_main_background;
    public $selected_main_body;
    public $selected_main_theme_text;
    public $selected_main_theme_background;
    public $selected_main_theme_text_active;
    public $selected_main_theme_background_active;
    public $selected_main_theme_border;
    public $selected_main_card_opacity;
    public $selected_main_card_text;
    //Main Group
    public $selected_cart_icon;
    public $selected_cart_back_icon;
    public $selected_cart_noti;
    public $selected_cart_back_noti;
    public $selected_cart_text;
    public $selected_cart_background;
    public $selected_cart_reset_text;
    public $selected_cart_reset_backgound;
    public $selected_cart_close_text;
    public $selected_cart_close_backgound;
    //Category Group
    public $selected_category_title;
    public $selected_category_description;
    public $selected_category_price;
    public $selected_category_old_price;
    public $selected_category_card_background;
    public $selected_category_shabow;
    //Food Detail Group
    public $selected_food_background;
    public $selected_food_title;
    public $selected_food_description;
    public $selected_food_price;
    public $selected_food_old_price;
    public $selected_food_price_key;
    public $selected_food_price_value;
    public $selected_food_button_text;
    public $selected_food_button_background;
    public $selected_food_image_shadow;
    public $selected_food_image_shadow_opacity;
    //Utilities
    public $selected_utl_icon_color;
    public $selected_utl_icon_background;

    public function mount()
    {
        // Load color values from the database based on the user's ID
        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $colors = $settings->default_lang ?? null;
        // Check if the colors data exists and assign them to Livewire properties
        if ($colors) {
            $color = json_decode($colors);
            //NAVBAR GROUP
            $this->selected_navbar_title = $color->selectedNavbarTitle ?? '#ffff00';
            $this->selected_navbar_toggle = $color->selectedNavbarToggle ?? '#766fa8';
            $this->selected_navbar_top = $color->selectedNavbarTop ?? '#766fa8';
            $this->selected_navbar_sub_title = $color->selectedNavbarSubTitle ?? '#766fa8';
            $this->selected_navbar_text = $color->selectedNavbarText ?? '#766fa8';
            $this->selected_navbar_top_ground = $color->selectedNavbarTopGround ?? '#766fa8';
            $this->selected_navbar_bottom_ground = $color->selectedNavbarBottomGround ?? '#766fa8';
            //Main Group
            $this->selected_main_background = $color->selectedMainBackground ?? '#ffff00';
            $this->selected_main_body = $color->selectedMainBody ?? '#ffff00';
            $this->selected_main_theme_text = $color->selectedMainThemeText ?? '#ffff00';
            $this->selected_main_theme_background = $color->selectedMainThemeBackgroud ?? '#ffff00';
            $this->selected_main_theme_text_active = $color->selectedMainThemeTextActive ?? '#ffff00';
            $this->selected_main_theme_background_active = $color->selectedMainThemeBackgroudActive ?? '#ffff00';
            $this->selected_main_theme_border = $color->selectedMainThemeBorder ?? '#ffff00';
            $this->selected_main_card_opacity = $color->selectedMainCardOpacity ?? '#ffff00';
            $this->selected_main_card_text = $color->selectedMainCardText ?? '#ffff00';
            //Cart Group
            $this->selected_cart_icon= $color->selectedCartIcon ?? '#ffff00';
            $this->selected_cart_back_icon = $color->selectedCartBackIcon ?? '#ffff00';
            $this->selected_cart_noti = $color->selectedCartNoti ?? '#ffff00';
            $this->selected_cart_back_noti = $color->selectedCartBackNoti ?? '#ffff00';
            $this->selected_cart_text = $color->selectedCartText ?? '#ffff00';
            $this->selected_cart_background = $color->selectedCartBackground ?? '#ffff00';
            $this->selected_cart_reset_text = $color->selectedCartResetText ?? '#ffff00';
            $this->selected_cart_reset_backgound = $color->selectedCartResetBackgound ?? '#ffff00';
            $this->selected_cart_close_text = $color->selectedCartCloseText ?? '#ffff00';
            $this->selected_cart_close_backgound = $color->selectedCartCloseBackgound ?? '#ffff00';
            //Category Group   
            $this->selected_category_title= $color->selectedCategoryTitle ?? '#ffff00';
            $this->selected_category_description = $color->selectedCategoryDescription ?? '#ffff00';
            $this->selected_category_price = $color->selectedCategoryPrice ?? '#ffff00';
            $this->selected_category_old_price = $color->selectedCategoryOldPrice ?? '#ffff00';
            $this->selected_category_card_background = $color->selectedCategoryCardBackground ?? '#ffff00';
            $this->selected_category_shabow = $color->selectedCategoryShabow ?? '#ffff00';
            //Food Detail Group
            $this->selected_food_background = $color->selectedFoodBackground ?? '#ffff00';
            $this->selected_food_title = $color->selectedFoodTitle ?? '#ffff00';
            $this->selected_food_description = $color->selectedFoodDescription ?? '#ffff00';
            $this->selected_food_price = $color->selectedFoodPrice ?? '#ffff00';
            $this->selected_food_old_price = $color->selectedFoodOldPrice ?? '#ffff00';
            $this->selected_food_button_text = $color->selectedFoodButtonText ?? '#ffff00';
            $this->selected_food_price_key = $color->selectedFoodPriceKey ?? '#ffff00';
            $this->selected_food_price_value = $color->selectedFoodPriceValue ?? '#ffff00';
            $this->selected_food_button_background = $color->selectedFoodButtonBackground ?? '#ffff00';
            $this->selected_food_image_shadow = $color->selectedFoodImageShadow ?? '#ffff00';
            $this->selected_food_image_shadow_opacity = $color->selectedFoodImageShadowOpacity ?? '#ffff00';
            //Utilities
            $this->selected_utl_icon_color = $color->selectedUtlIconColor ?? '#ffff00';
            $this->selected_utl_icon_background = $color->selectedUtlIconBackground ?? '#ffff00';
        }
    }

    public function render()
    {
        return view('dashboard.livewire.design-customize-form');
    }


    public function saveColors(){

        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $settings->default_lang = [
             //NAVBAR GROUP
            'selectedNavbarTitle' => $this->selected_navbar_title ?? '#766fa8',
            'selectedNavbarToggle' => $this->selected_navbar_toggle ?? '0.20',
            'selectedNavbarTop' => $this->selected_navbar_top ?? '#766fa8',
            'selectedNavbarSubTitle' => $this->selected_navbar_sub_title ?? '0.90',
            'selectedNavbarText' => $this->selected_navbar_text ?? '#766fa8',
            'selectedNavbarTopGround' => $this->selected_navbar_top_ground ?? '1.0',
            'selectedNavbarBottomGround' => $this->selected_navbar_bottom_ground ?? '1.0',
            //Main Group
            'selectedMainBackground' => $this->selected_main_background ?? '#ffff00',
            'selectedMainBody' => $this->selected_main_body ?? '#ffff00',
            'selectedMainThemeText' => $this->selected_main_theme_text ?? '#ffff00',
            'selectedMainThemeBackgroud' => $this->selected_main_theme_background ?? '#ffff00',
            'selectedMainThemeTextActive' => $this->selected_main_theme_text_active ?? '#ffff00',
            'selectedMainThemeBackgroudActive' => $this->selected_main_theme_background_active ?? '#ffff00',
            'selectedMainThemeBorder' => $this->selected_main_theme_border ?? '#ffff00',
            'selectedMainCardOpacity' => $this->selected_main_card_opacity ?? '#ffff00',
            'selectedMainCardText' => $this->selected_main_card_text ?? '#ffff00',
            //Cart Group
            'selectedCartIcon' => $this->selected_cart_icon ?? '#ffff00',
            'selectedCartBackIcon' => $this->selected_cart_back_icon ?? '#ffff00',
            'selectedCartNoti' => $this->selected_cart_noti ?? '#ffff00',
            'selectedCartBackNoti' => $this->selected_cart_back_noti ?? '#ffff00',
            'selectedCartText' => $this->selected_cart_text ?? '#ffff00',
            'selectedCartBackground' => $this->selected_cart_background ?? '#ffff00',
            'selectedCartResetText' => $this->selected_cart_reset_text ?? '#ffff00',
            'selectedCartResetBackgound' => $this->selected_cart_reset_backgound ?? '#ffff00',
            'selectedCartCloseText' => $this->selected_cart_close_text ?? '#ffff00',
            'selectedCartCloseBackgound' => $this->selected_cart_close_backgound ?? '#ffff00',
            //Category Group   
            'selectedCategoryTitle' => $this->selected_category_title ?? '#ffff00',
            'selectedCategoryDescription' => $this->selected_category_description ?? '#ffff00',
            'selectedCategoryPrice' => $this->selected_category_price ?? '#ffff00',
            'selectedCategoryOldPrice' => $this->selected_category_old_price ?? '#ffff00',
            'selectedCategoryCardBackground' => $this->selected_category_card_background ?? '#ffff00',
            'selectedCategoryShabow' => $this->selected_category_shabow ?? '#ffff00',
            //Food Detail Group
            'selectedFoodBackground' => $this->selected_food_background ?? '#ffff00',
            'selectedFoodTitle' => $this->selected_food_title ?? '#ffff00',
            'selectedFoodDescription' => $this->selected_food_description ?? '#ffff00',
            'selectedFoodPrice' => $this->selected_food_price ?? '#ffff00',
            'selectedFoodOldPrice' => $this->selected_food_old_price ?? '#ffff00',
            'selectedFoodPriceKey' => $this->selected_food_price_key ?? '#ffff00',
            'selectedFoodPriceValue' => $this->selected_food_price_value ?? '#ffff00',
            'selectedFoodButtonText' => $this->selected_food_button_text ?? '#ffff00',
            'selectedFoodButtonBackground' => $this->selected_food_button_background ?? '#ffff00',
            'selectedFoodImageShadow' => $this->selected_food_image_shadow ?? '#ffff00',
            'selectedFoodImageShadowOpacity' => $this->selected_food_image_shadow_opacity ?? '0.25',
            //Utilities
            'selectedUtlIconColor' => $this->selected_utl_icon_color ?? '#ff0022',
            'selectedUtlIconBackground' => $this->selected_utl_icon_background ?? 'ff0022',

        ];
        $settings->save();

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);
    }
}

