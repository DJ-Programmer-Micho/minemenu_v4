<?php
 
namespace App\Http\Livewire\Dashboard;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
 
class DesignCustomizeLivewire extends Component
{
    public $lang;
    public $filteredLocales;
    // FormLocal
    public $formFields;
    public $presetNameToSave;
    public $user_color;

    //START GROUP
    public $selected_start_button_text;
    public $selected_start_button_background;
    public $selected_start_opacity;
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
    public $selected_main_card_text;
    public $selected_main_card_opacity;
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
    public $selected_category_button_text;
    public $selected_category_button_background;
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
        // $this->user_color = [];
        $this->user_color = $settings->user_ui_color ?? [];
        $colors = $settings->ui_color ?? [];
        // Check if the colors data exists and assign them to Livewire properties
        $imgExsistHeader = $settings->background_img_header;
        $imgExsistLogo = $settings->background_img_avatar;

        if($imgExsistHeader){
            $this->imgReader = $imgExsistHeader;
            $this->tempImg = app('cloudfront').$imgExsistHeader;
        }
        if($imgExsistLogo){
            $this->imgReaderLogo = $imgExsistLogo;
            $this->tempImgLogo = app('cloudfront').$imgExsistLogo;
        }

        if ($colors) {
            $color = json_decode($colors);
            // dd($color->selectedNavbarTitle);
            //START GROUP
            $this->selected_start_button_text = $color->selectedStartButtonText ?? '#ffffff';
            $this->selected_start_button_background = $color->selectedStartButtonBackground ?? '#cc0022';
            $this->selected_start_opacity = $color->selectedStartOpacity ?? '0.3';
            //NAVBAR GROUP
            $this->selected_navbar_title = $color->selectedNavbarTitle ?? '#cc0022';
            $this->selected_navbar_toggle = $color->selectedNavbarToggle ?? '#000000';
            $this->selected_navbar_top = $color->selectedNavbarTop ?? '#ffffff';
            $this->selected_navbar_sub_title = $color->selectedNavbarSubTitle ?? '#b97e87';
            $this->selected_navbar_text = $color->selectedNavbarText ?? '#766fa8';
            $this->selected_navbar_top_ground = $color->selectedNavbarTopGround ?? '#766fa8';
            $this->selected_navbar_bottom_ground = $color->selectedNavbarBottomGround ?? '#766fa8';
            //Main Group
            $this->selected_main_background = $color->selectedMainBackground ?? '#ffffff';
            $this->selected_main_body = $color->selectedMainBody ?? '#b8b8b8';
            $this->selected_main_theme_text = $color->selectedMainThemeText ?? '#cc0022';
            $this->selected_main_theme_background = $color->selectedMainThemeBackground ?? '#ffffff';
            $this->selected_main_theme_text_active = $color->selectedMainThemeTextActive ?? '#cc0022';
            $this->selected_main_theme_background_active = $color->selectedMainThemeBackgroundActive ?? '#ffffff';
            $this->selected_main_theme_border = $color->selectedMainThemeBorder ?? '#cc0022';
            $this->selected_main_card_text = $color->selectedMainCardText ?? '#ffffff';
            $this->selected_main_card_opacity = $color->selectedMainCardOpacity ?? '0.3';
            //Cart Group
            $this->selected_cart_icon= $color->selectedCartIcon ?? '#ffffff';
            $this->selected_cart_back_icon = $color->selectedCartBackIcon ?? '#333234';
            $this->selected_cart_noti = $color->selectedCartNoti ?? '#ffffff';
            $this->selected_cart_back_noti = $color->selectedCartBackNoti ?? '#cc0022';
            $this->selected_cart_text = $color->selectedCartText ?? '#000000';
            $this->selected_cart_background = $color->selectedCartBackground ?? '#ffffff';
            $this->selected_cart_reset_text = $color->selectedCartResetText ?? '#ffffff';
            $this->selected_cart_reset_backgound = $color->selectedCartResetBackgound ?? '#cc0022';
            $this->selected_cart_close_text = $color->selectedCartCloseText ?? '#ffffff';
            $this->selected_cart_close_backgound = $color->selectedCartCloseBackgound ?? '#cc0022';
            //Category Group   
            $this->selected_category_title= $color->selectedCategoryTitle ?? '#cc0022';
            $this->selected_category_description = $color->selectedCategoryDescription ?? '#000000';
            $this->selected_category_price = $color->selectedCategoryPrice ?? '#000000';
            $this->selected_category_old_price = $color->selectedCategoryOldPrice ?? '#cc0022';
            $this->selected_category_card_background = $color->selectedCategoryCardBackground ?? '#ffffff';
            $this->selected_category_shabow = $color->selectedCategoryShabow ?? '#dedede';
            $this->selected_category_button_text = $color->selectedCategoryButtonText ?? '#ffffff';
            $this->selected_category_button_background = $color->selectedCategoryButtonBackground ?? '#cc0022';
            //Food Detail Group
            $this->selected_food_background = $color->selectedFoodBackground ?? '#ffffff';
            $this->selected_food_title = $color->selectedFoodTitle ?? '#cc0022';
            $this->selected_food_description = $color->selectedFoodDescription ?? '#000000';
            $this->selected_food_price = $color->selectedFoodPrice ?? '#000000';
            $this->selected_food_old_price = $color->selectedFoodOldPrice ?? '#cc0022';
            $this->selected_food_button_text = $color->selectedFoodButtonText ?? '#000000';
            $this->selected_food_price_key = $color->selectedFoodPriceKey ?? '#000000';
            $this->selected_food_price_value = $color->selectedFoodPriceValue ?? '#ffffff';
            $this->selected_food_button_background = $color->selectedFoodButtonBackground ?? '#cc0022';
            $this->selected_food_image_shadow = $color->selectedFoodImageShadow ?? '#cc0022';
            $this->selected_food_image_shadow_opacity = $color->selectedFoodImageShadowOpacity ?? '0.1';
            //Utilities
            $this->selected_utl_icon_color = $color->selectedUtlIconColor ?? '#ffffff';
            $this->selected_utl_icon_background = $color->selectedUtlIconBackground ?? '#323334';
        }
    }

    public function render()
    {
        // return view('dashboard.livewire.design-customize-form');
        return view('dashboard.livewire.design-customize-form', ['user_color' => $this->user_color]);
    }


    public function saveColors(){

        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $settings->ui_color = [
             //START GROUP
            'selectedStartButtonText' => $this->selected_start_button_text ?? '#ffffff',
            'selectedStartButtonBackground' => $this->selected_start_button_background ?? '#cc0022',
            'selectedStartOpacity' => $this->selected_start_opacity ?? '0.3',
             //NAVBAR GROUP
            'selectedNavbarTitle' => $this->selected_navbar_title ?? '#cc0022',
            'selectedNavbarToggle' => $this->selected_navbar_toggle ?? '#000000',
            'selectedNavbarTop' => $this->selected_navbar_top ?? '#ffffff',
            'selectedNavbarSubTitle' => $this->selected_navbar_sub_title ?? '#b97e87',
            'selectedNavbarText' => $this->selected_navbar_text ?? '#766fa8',
            'selectedNavbarTopGround' => $this->selected_navbar_top_ground ?? '#766fa8',
            'selectedNavbarBottomGround' => $this->selected_navbar_bottom_ground ?? '#766fa8',
            //Main Group
            'selectedMainBackground' => $this->selected_main_background ?? '#ffffff',
            'selectedMainBody' => $this->selected_main_body ?? '#b8b8b8',
            'selectedMainThemeText' => $this->selected_main_theme_text ?? '#cc0022',
            'selectedMainThemeBackground' => $this->selected_main_theme_background ?? '#ffffff',
            'selectedMainThemeTextActive' => $this->selected_main_theme_text_active ?? '#cc0022',
            'selectedMainThemeBackgroundActive' => $this->selected_main_theme_background_active ?? '#ffffff',
            'selectedMainThemeBorder' => $this->selected_main_theme_border ?? '#cc0022',
            'selectedMainCardText' => $this->selected_main_card_text ?? '#ffffff',
            'selectedMainCardOpacity' => $this->selected_main_card_opacity ?? '0.3',
            //Cart Group
            'selectedCartIcon' => $this->selected_cart_icon ?? '#ffffff',
            'selectedCartBackIcon' => $this->selected_cart_back_icon ?? '#333234',
            'selectedCartNoti' => $this->selected_cart_noti ?? '#ffffff',
            'selectedCartBackNoti' => $this->selected_cart_back_noti ?? '#cc0022',
            'selectedCartText' => $this->selected_cart_text ?? '#000000',
            'selectedCartBackground' => $this->selected_cart_background ?? '#ffffff',
            'selectedCartResetText' => $this->selected_cart_reset_text ?? '#ffffff',
            'selectedCartResetBackgound' => $this->selected_cart_reset_backgound ?? '#cc0022',
            'selectedCartCloseText' => $this->selected_cart_close_text ?? '#ffffff',
            'selectedCartCloseBackgound' => $this->selected_cart_close_backgound ?? '#cc0022',
            //Category Group   
            'selectedCategoryTitle' => $this->selected_category_title ?? '#cc0022',
            'selectedCategoryDescription' => $this->selected_category_description ?? '#000000',
            'selectedCategoryPrice' => $this->selected_category_price ?? '#000000',
            'selectedCategoryOldPrice' => $this->selected_category_old_price ?? '#cc0022',
            'selectedCategoryCardBackground' => $this->selected_category_card_background ?? '#ffffff',
            'selectedCategoryShabow' => $this->selected_category_shabow ?? '#dedede',
            'selectedCategoryButtonText' => $this->selected_category_button_text ?? '#ffffff',
            'selectedCategoryButtonBackground' => $this->selected_category_button_background ?? '#cc0022',
            //Food Detail Group
            'selectedFoodBackground' => $this->selected_food_background ?? '#ffffff',
            'selectedFoodTitle' => $this->selected_food_title ?? '#cc0022',
            'selectedFoodDescription' => $this->selected_food_description ?? '#000000',
            'selectedFoodPrice' => $this->selected_food_price ?? '#000000',
            'selectedFoodOldPrice' => $this->selected_food_old_price ?? '#cc0022',
            'selectedFoodPriceKey' => $this->selected_food_price_key ?? '#000000',
            'selectedFoodPriceValue' => $this->selected_food_price_value ?? '#000000',
            'selectedFoodButtonText' => $this->selected_food_button_text ?? '#ffffff',
            'selectedFoodButtonBackground' => $this->selected_food_button_background ?? '#cc0022',
            'selectedFoodImageShadow' => $this->selected_food_image_shadow ?? '#cc0022',
            'selectedFoodImageShadowOpacity' => $this->selected_food_image_shadow_opacity ?? '0.1',
            //Utilities
            'selectedUtlIconColor' => $this->selected_utl_icon_color ?? '#ffffff',
            'selectedUtlIconBackground' => $this->selected_utl_icon_background ?? '#323334',

        ];
        $settings->save();

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Settings Updated successfully')]);
    }


    public function saveNewPreset($index){

        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $presetName = $this->presetNameToSave;
        $userPresetHandler = $settings->user_ui_color ?? [];
        $aa = [
            'name' => $presetName,
            //START GROUP
            'selectedStartButtonText' => $this->selected_start_button_text ?? '#ffffff',
            'selectedStartButtonBackground' => $this->selected_start_button_background ?? '#cc0022',
            'selectedStartOpacity' => $this->selected_start_opacity ?? '0.3',
            //NAVBAR GROUP
            'selectedNavbarTitle' => $this->selected_navbar_title ?? '#cc0022',
            'selectedNavbarToggle' => $this->selected_navbar_toggle ?? '#000000',
            'selectedNavbarTop' => $this->selected_navbar_top ?? '#ffffff',
            'selectedNavbarSubTitle' => $this->selected_navbar_sub_title ?? '#b97e87',
            'selectedNavbarText' => $this->selected_navbar_text ?? '#766fa8',
            'selectedNavbarTopGround' => $this->selected_navbar_top_ground ?? '#766fa8',
            'selectedNavbarBottomGround' => $this->selected_navbar_bottom_ground ?? '#766fa8',
            //Main Group
            'selectedMainBackground' => $this->selected_main_background ?? '#ffffff',
            'selectedMainBody' => $this->selected_main_body ?? '#b8b8b8',
            'selectedMainThemeText' => $this->selected_main_theme_text ?? '#cc0022',
            'selectedMainThemeBackground' => $this->selected_main_theme_background ?? '#ffffff',
            'selectedMainThemeTextActive' => $this->selected_main_theme_text_active ?? '#cc0022',
            'selectedMainThemeBackgroundActive' => $this->selected_main_theme_background_active ?? '#ffffff',
            'selectedMainThemeBorder' => $this->selected_main_theme_border ?? '#cc0022',
            'selectedMainCardText' => $this->selected_main_card_text ?? '#ffffff',
            'selectedMainCardOpacity' => $this->selected_main_card_opacity ?? '0.3',
            //Cart Group
            'selectedCartIcon' => $this->selected_cart_icon ?? '#ffffff',
            'selectedCartBackIcon' => $this->selected_cart_back_icon ?? '#333234',
            'selectedCartNoti' => $this->selected_cart_noti ?? '#ffffff',
            'selectedCartBackNoti' => $this->selected_cart_back_noti ?? '#cc0022',
            'selectedCartText' => $this->selected_cart_text ?? '#000000',
            'selectedCartBackground' => $this->selected_cart_background ?? '#ffffff',
            'selectedCartResetText' => $this->selected_cart_reset_text ?? '#ffffff',
            'selectedCartResetBackgound' => $this->selected_cart_reset_backgound ?? '#cc0022',
            'selectedCartCloseText' => $this->selected_cart_close_text ?? '#ffffff',
            'selectedCartCloseBackgound' => $this->selected_cart_close_backgound ?? '#cc0022',
            //Category Group   
            'selectedCategoryTitle' => $this->selected_category_title ?? '#cc0022',
            'selectedCategoryDescription' => $this->selected_category_description ?? '#000000',
            'selectedCategoryPrice' => $this->selected_category_price ?? '#000000',
            'selectedCategoryOldPrice' => $this->selected_category_old_price ?? '#cc0022',
            'selectedCategoryCardBackground' => $this->selected_category_card_background ?? '#ffffff',
            'selectedCategoryShabow' => $this->selected_category_shabow ?? '#dedede',
            'selectedCategoryButtonText' => $this->selected_category_button_text ?? '#ffffff',
            'selectedCategoryButtonBackground' => $this->selected_category_button_background ?? '#cc0022',
            //Food Detail Group
            'selectedFoodBackground' => $this->selected_food_background ?? '#ffffff',
            'selectedFoodTitle' => $this->selected_food_title ?? '#cc0022',
            'selectedFoodDescription' => $this->selected_food_description ?? '#000000',
            'selectedFoodPrice' => $this->selected_food_price ?? '#000000',
            'selectedFoodOldPrice' => $this->selected_food_old_price ?? '#cc0022',
            'selectedFoodPriceKey' => $this->selected_food_price_key ?? '#000000',
            'selectedFoodPriceValue' => $this->selected_food_price_value ?? '#000000',
            'selectedFoodButtonText' => $this->selected_food_button_text ?? '#ffffff',
            'selectedFoodButtonBackground' => $this->selected_food_button_background ?? '#cc0022',
            'selectedFoodImageShadow' => $this->selected_food_image_shadow ?? '#cc0022',
            'selectedFoodImageShadowOpacity' => $this->selected_food_image_shadow_opacity ?? '0.1',
            //Utilities
            'selectedUtlIconColor' => $this->selected_utl_icon_color ?? '#ffffff',
            'selectedUtlIconBackground' => $this->selected_utl_icon_background ?? '#323334',
        ];
        $userPresetHandler[$index] = $aa;

        // Reindex the array to ensure numerical indexes (0, 1, 2, etc.)
        $userPresetHandler = array_values($userPresetHandler);
        
        // Assign the modified array back to the ui_color property
        $settings->user_ui_color = $userPresetHandler;
        $settings->save();

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('User preset Save successfully')]);
        $this->dispatchBrowserEvent('refreshSave');
    }

    public function saveExistPreset($index, $name){
        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $userPresetHandler = $settings->user_ui_color ?? [];
        $aa = [
            'name' => $name,
            //START GROUP
            'selectedStartButtonText' => $this->selected_start_button_text ?? '#ffffff',
            'selectedStartButtonBackground' => $this->selected_start_button_background ?? '#cc0022',
            'selectedStartOpacity' => $this->selected_start_opacity ?? '0.3',
            //NAVBAR GROUP
            'selectedNavbarTitle' => $this->selected_navbar_title ?? '#cc0022',
            'selectedNavbarToggle' => $this->selected_navbar_toggle ?? '#000000',
            'selectedNavbarTop' => $this->selected_navbar_top ?? '#ffffff',
            'selectedNavbarSubTitle' => $this->selected_navbar_sub_title ?? '#b97e87',
            'selectedNavbarText' => $this->selected_navbar_text ?? '#766fa8',
            'selectedNavbarTopGround' => $this->selected_navbar_top_ground ?? '#766fa8',
            'selectedNavbarBottomGround' => $this->selected_navbar_bottom_ground ?? '#766fa8',
            //Main Group
            'selectedMainBackground' => $this->selected_main_background ?? '#ffffff',
            'selectedMainBody' => $this->selected_main_body ?? '#b8b8b8',
            'selectedMainThemeText' => $this->selected_main_theme_text ?? '#cc0022',
            'selectedMainThemeBackground' => $this->selected_main_theme_background ?? '#ffffff',
            'selectedMainThemeTextActive' => $this->selected_main_theme_text_active ?? '#cc0022',
            'selectedMainThemeBackgroundActive' => $this->selected_main_theme_background_active ?? '#ffffff',
            'selectedMainThemeBorder' => $this->selected_main_theme_border ?? '#cc0022',
            'selectedMainCardText' => $this->selected_main_card_text ?? '#ffffff',
            'selectedMainCardOpacity' => $this->selected_main_card_opacity ?? '0.3',
            //Cart Group
            'selectedCartIcon' => $this->selected_cart_icon ?? '#ffffff',
            'selectedCartBackIcon' => $this->selected_cart_back_icon ?? '#333234',
            'selectedCartNoti' => $this->selected_cart_noti ?? '#ffffff',
            'selectedCartBackNoti' => $this->selected_cart_back_noti ?? '#cc0022',
            'selectedCartText' => $this->selected_cart_text ?? '#000000',
            'selectedCartBackground' => $this->selected_cart_background ?? '#ffffff',
            'selectedCartResetText' => $this->selected_cart_reset_text ?? '#ffffff',
            'selectedCartResetBackgound' => $this->selected_cart_reset_backgound ?? '#cc0022',
            'selectedCartCloseText' => $this->selected_cart_close_text ?? '#ffffff',
            'selectedCartCloseBackgound' => $this->selected_cart_close_backgound ?? '#cc0022',
            //Category Group   
            'selectedCategoryTitle' => $this->selected_category_title ?? '#cc0022',
            'selectedCategoryDescription' => $this->selected_category_description ?? '#000000',
            'selectedCategoryPrice' => $this->selected_category_price ?? '#000000',
            'selectedCategoryOldPrice' => $this->selected_category_old_price ?? '#cc0022',
            'selectedCategoryCardBackground' => $this->selected_category_card_background ?? '#ffffff',
            'selectedCategoryShabow' => $this->selected_category_shabow ?? '#dedede',
            'selectedCategoryButtonText' => $this->selected_category_button_text ?? '#ffffff',
            'selectedCategoryButtonBackground' => $this->selected_category_button_background ?? '#cc0022',
            //Food Detail Group
            'selectedFoodBackground' => $this->selected_food_background ?? '#ffffff',
            'selectedFoodTitle' => $this->selected_food_title ?? '#cc0022',
            'selectedFoodDescription' => $this->selected_food_description ?? '#000000',
            'selectedFoodPrice' => $this->selected_food_price ?? '#000000',
            'selectedFoodOldPrice' => $this->selected_food_old_price ?? '#cc0022',
            'selectedFoodPriceKey' => $this->selected_food_price_key ?? '#000000',
            'selectedFoodPriceValue' => $this->selected_food_price_value ?? '#000000',
            'selectedFoodButtonText' => $this->selected_food_button_text ?? '#ffffff',
            'selectedFoodButtonBackground' => $this->selected_food_button_background ?? '#cc0022',
            'selectedFoodImageShadow' => $this->selected_food_image_shadow ?? '#cc0022',
            'selectedFoodImageShadowOpacity' => $this->selected_food_image_shadow_opacity ?? '0.1',
            //Utilities
            'selectedUtlIconColor' => $this->selected_utl_icon_color ?? '#ffffff',
            'selectedUtlIconBackground' => $this->selected_utl_icon_background ?? '#323334',
        ];
        $userPresetHandler[$index] = $aa;

        // Reindex the array to ensure numerical indexes (0, 1, 2, etc.)
        $userPresetHandler = array_values($userPresetHandler);
        
        // Assign the modified array back to the ui_color property
        $settings->user_ui_color = $userPresetHandler;
        $settings->save();

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('User preset overwrite successfully')]);
        $this->dispatchBrowserEvent('refreshSave');
    }

    public function loadPreset($index)
    {
        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $user_color_load = $settings->user_ui_color ?? [];
        // Check if the colors data exists and assign them to Livewire properties
        if ($user_color_load[$index]) {
    
            $user_color = $user_color_load[$index];
            //START GROUP
            $this->selected_start_button_text = $user_color['selectedStartButtonText'] ?? '#ffffff';
            $this->selected_start_button_background = $user_color['selectedStartButtonBackground'] ?? '#cc0022';
            $this->selected_start_opacity = $user_color['selectedStartOpacity'] ?? '0.3';
            //NAVBAR GROUP
            $this->selected_navbar_title = $user_color['selectedNavbarTitle'] ?? '#cc0022';
            $this->selected_navbar_toggle = $user_color['selectedNavbarToggle'] ?? '#000000';
            $this->selected_navbar_top = $user_color['selectedNavbarTop'] ?? '#ffffff';
            $this->selected_navbar_sub_title = $user_color['selectedNavbarSubTitle'] ?? '#b97e87';
            $this->selected_navbar_text = $user_color['selectedNavbarText'] ?? '#766fa8';
            $this->selected_navbar_top_ground = $user_color['selectedNavbarTopGround'] ?? '#766fa8';
            $this->selected_navbar_bottom_ground = $user_color['selectedNavbarBottomGround'] ?? '#766fa8';
            //Main Group
            $this->selected_main_background = $user_color['selectedMainBackground'] ?? '#ffffff';
            $this->selected_main_body = $user_color['selectedMainBody'] ?? '#b8b8b8';
            $this->selected_main_theme_text = $user_color['selectedMainThemeText'] ?? '#cc0022';
            $this->selected_main_theme_background = $user_color['selectedMainThemeBackground'] ?? '#ffffff';
            $this->selected_main_theme_text_active = $user_color['selectedMainThemeTextActive'] ?? '#cc0022';
            $this->selected_main_theme_background_active = $user_color['selectedMainThemeBackgroundActive'] ?? '#ffffff';
            $this->selected_main_theme_border = $user_color['selectedMainThemeBorder'] ?? '#cc0022';
            $this->selected_main_card_text = $user_color['selectedMainCardText'] ?? '#ffffff';
            $this->selected_main_card_opacity = $user_color['selectedMainCardOpacity'] ?? '0.3';
            //Cart Group
            $this->selected_cart_icon= $user_color['selectedCartIcon'] ?? '#ffffff';
            $this->selected_cart_back_icon = $user_color['selectedCartBackIcon'] ?? '#333234';
            $this->selected_cart_noti = $user_color['selectedCartNoti'] ?? '#ffffff';
            $this->selected_cart_back_noti = $user_color['selectedCartBackNoti'] ?? '#cc0022';
            $this->selected_cart_text = $user_color['selectedCartText'] ?? '#000000';
            $this->selected_cart_background = $user_color['selectedCartBackground'] ?? '#ffffff';
            $this->selected_cart_reset_text = $user_color['selectedCartResetText'] ?? '#ffffff';
            $this->selected_cart_reset_backgound = $user_color['selectedCartResetBackgound'] ?? '#cc0022';
            $this->selected_cart_close_text = $user_color['selectedCartCloseText'] ?? '#ffffff';
            $this->selected_cart_close_backgound = $user_color['selectedCartCloseBackgound'] ?? '#cc0022';
            //Category Group   
            $this->selected_category_title= $user_color['selectedCategoryTitle'] ?? '#cc0022';
            $this->selected_category_description = $user_color['selectedCategoryDescription'] ?? '#000000';
            $this->selected_category_price = $user_color['selectedCategoryPrice'] ?? '#000000';
            $this->selected_category_old_price = $user_color['selectedCategoryOldPrice'] ?? '#cc0022';
            $this->selected_category_card_background = $user_color['selectedCategoryCardBackground'] ?? '#ffffff';
            $this->selected_category_shabow = $user_color['selectedCategoryShabow'] ?? '#dedede';
            $this->selected_category_button_text = $user_color['selectedCategoryButtonText'] ?? '#ffffff';
            $this->selected_category_button_background = $user_color['selectedCategoryButtonBackground'] ?? '#cc0022';
            //Food Detail Group
            $this->selected_food_background = $user_color['selectedFoodBackground'] ?? '#ffffff';
            $this->selected_food_title = $user_color['selectedFoodTitle'] ?? '#cc0022';
            $this->selected_food_description = $user_color['selectedFoodDescription'] ?? '#000000';
            $this->selected_food_price = $user_color['selectedFoodPrice'] ?? '#000000';
            $this->selected_food_old_price = $user_color['selectedFoodOldPrice'] ?? '#cc0022';
            $this->selected_food_button_text = $user_color['selectedFoodButtonText'] ?? '#000000';
            $this->selected_food_price_key = $user_color['selectedFoodPriceKey'] ?? '#000000';
            $this->selected_food_price_value = $user_color['selectedFoodPriceValue'] ?? '#ffffff';
            $this->selected_food_button_background = $user_color['selectedFoodButtonBackground'] ?? '#cc0022';
            $this->selected_food_image_shadow = $user_color['selectedFoodImageShadow'] ?? '#cc0022';
            $this->selected_food_image_shadow_opacity = $user_color['selectedFoodImageShadowOpacity'] ?? '0.1';
            //Utilities
            $this->selected_utl_icon_color = $user_color['selectedUtlIconColor'] ?? '#ffffff';
            $this->selected_utl_icon_background = $user_color['selectedUtlIconBackground'] ?? '#323334';
        }
        $this->dispatchBrowserEvent('userPreset');
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('User preset Set successfully')]);
    }

    public function deletePreset($index)
    {
        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $user_color_delete = $settings->user_ui_color;
        unset($user_color_delete[$index]);
        $settings->user_ui_color = $user_color_delete;
        $settings->save();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('User preset Deleted successfully')]);
        $this->dispatchBrowserEvent('refreshDelete');
    }

    // public $selectedPreset;
    public $presetData;

    public function fixedPreset($px){
        $presets = [
            'p1' => [
                'startButtonText' => '#ffffff',
                'startButtonBackground' => '#cc0022',
                'startOpacity' => '0.3',
                'navbarTitle' => '#cc0022',
                'navbarToggle' => '#cc0022',
                'navbarTop' => '#ffffff',
                'navbarSubTitle' => '#cc0022',
                'navbarText' => '#000000',
                'navbarTopGround' => '#ffffff',
                'navbarBottomGround' => '#b97e87',
                'mainBackground' => '#ffffff',
                'mainBody' => '#b8b8b8',
                'mainThemeText' => '#cc0022',
                'mainThemeBackground' => '#ffffff',
                'mainThemeTextActive' => '#cc0022',
                'mainThemeBackgroundActive' => '#ffffff',
                'mainThemeBorder' => '#cc0022',
                'mainCardText' => '#ffffff',
                'mainCardOpacity' => '0.3',
                'cartIcon' => '#ffffff',
                'cartBackIcon' => '#333234',
                'cartNoti' => '#ffffff',
                'cartBackNoti' => '#cc0022',
                'cartText' => '#000000',
                'cartBackground' => '#ffffff',
                'cartResetext' => '#ffffff',
                'cartResetBackgound' => '#cc0022',
                'cartCloseText' => '#ffffff',
                'cartCloseBackgound' => '#cc0022',
                'categoryTitle' => '#cc0022',
                'categoryDescription' => '#000000',
                'categoryPrice' => '#000000',
                'categoryOldPrice' => '#cc0022',
                'categoryCardBackground' => '#ffffff',
                'categoryShabow' => '#dedede',
                'categoryButtonText' => '#ffffff',
                'categoryButtonBackground' => '#cc0022',
                'foodBackground' => '#ffffff',
                'foodTitle' => '#cc0022',
                'foodDescription' => '#000000',
                'foodPrice' => '#000000',
                'foodOldPrice' => '#cc0022',
                'foodPriceKey' => '#000000',
                'foodPriceValue' => '#000000',
                'foodButtonText' => '#ffffff',
                'foodButtonBackground' => '#cc0022',
                'foodImageShadow' => '#cc0022',
                'foodImageShadowOpacity' => '0.1',
                'utlIconColor' => '#ffffff',
                'utlIconBackground' => '#323334',
            ],
            'p2' => [
                'startButtonText' => '#ffffff',
                'startButtonBackground' => '#1b3165',
                'startOpacity' => '0.3',
                'navbarTitle' => '#1b3165',
                'navbarToggle' => '#1b3165',
                'navbarTop' => '#ffffff',
                'navbarSubTitle' => '#1b3165',
                'navbarText' => '#1b3165',
                'navbarTopGround' => '#ffffff',
                'navbarBottomGround' => '#7e98b9',
                'mainBackground' => '#ffffff',
                'mainBody' => '#b8b8b8',
                'mainThemeText' => '#006aff',
                'mainThemeBackground' => '#ffffff',
                'mainThemeTextActive' => '#0097fc',
                'mainThemeBackgroundActive' => '#ffffff',
                'mainThemeBorder' => '#0097fc',
                'mainCardText' => '#b0dcf6',
                'mainCardOpacity' => '0.4',
                'cartIcon' => '#ffffff',
                'cartBackIcon' => '#333234',
                'cartNoti' => '#ffffff',
                'cartBackNoti' => '#006aff',
                'cartText' => '#1b3165',
                'cartBackground' => '#e1edf4',
                'cartResetText' => '#ffffff',
                'cartResetBackgound' => '#f27579',
                'cartCloseText' => '#ffffff',
                'cartCloseBackgound' => '#f27579',
                'categoryTitle' => '#006aff',
                'categoryDescription' => '#000000',
                'categoryPrice' => '#000000',
                'categoryOldPrice' => '#f27579',
                'categoryCardBackground' => '#ffffff',
                'categoryShabow' => '#dedede',
                'categoryButtonText' => '#ffffff',
                'categoryButtonBackground' => '#1b3165',
                'foodBackground' => '#ffffff',
                'foodTitle' => '#006aff',
                'foodDescription' => '#000000',
                'foodPrice' => '#000000',
                'foodOldPrice' => '#f27579',
                'foodPriceKey' => '#000000',
                'foodPriceValue' => '#ffffff',
                'foodButtonText' => '#ffffff',
                'foodButtonBackground' => '#1b3165',
                'foodImageShadow' => '#b0dcf6',
                'foodImageShadowOpacity' => '0.1',
                'utlIconColor' => '#ffffff',
                'utlIconBackground' => '#323334',
            ],
            'p3' => [
                'startButtonText' => '#ffffff',
                'startButtonBackground' => '#131816',
                'startOpacity' => '0.3',
                'navbarTitle' => '#f6f5e5',
                'navbarToggle' => '#f6f5e5',
                'navbarTop' => '#131816',
                'navbarSubTitle' => '#cb4ccf',
                'navbarText' => '#f6f5e5',
                'navbarTopGround' => '#131816',
                'navbarBottomGround' => '#231d1e',
                'mainBackground' => '#131816',
                'mainBody' => '#1c211f',
                'mainThemeText' => '#cb4ccf',
                'mainThemeBackground' => '#131816',
                'mainThemeTextActive' => '#cb4ccf',
                'mainThemeBackgroundActive' => '#231d1e',
                'mainThemeBorder' => '#cb4ccf',
                'mainCardOpacity' => '0.3',
                'mainCardText' => '#ffffff',
                'cartIcon' => '#cb4ccf',
                'cartBackIcon' => '#131816',
                'cartNoti' => '#cb4ccf',
                'cartBackNoti' => '#131816',
                'cartText' => '#edecdd',
                'cartBackground' => '#131816',
                'cartResetext' => '#131816',
                'cartResetBackgound' => '#e6d7a9',
                'cartCloseText' => '#ffffff',
                'cartCloseBackgound' => '#231d1e',
                'categoryTitle' => '#e6d7a9',
                'categoryDescription' => '#e6d7a9',
                'categoryPrice' => '#e6d7a9',
                'categoryOldPrice' => '#cb4ccf',
                'categoryCardBackground' => '#1c211f',
                'categoryShabow' => '#272b29',
                'categoryButtonText' => '#1c211f',
                'categoryButtonBackground' => '#07e2e4',
                'foodBackground' => '#131816',
                'foodTitle' => '#e6d7a9',
                'foodDescription' => '#e6d7a9',
                'foodPrice' => '#07e2e4',
                'foodOldPrice' => '#cb4ccf',
                'foodPriceKey' => '#07e2e4',
                'foodPriceValue' => '#cb4ccf',
                'foodButtonText' => '#131816',
                'foodButtonBackground' => '#e6d7a9',
                'foodImageShadow' => '#4e4d46',
                'foodImageShadowOpacity' => '0.9',
                'utlIconColor' => '#cb4ccf',
                'utlIconBackground' => '#131816',
            ],
            'p4' => [
                'startButtonText' => '#ffffff',
                'startButtonBackground' => '#004a40',
                'startOpacity' => '0.3',
                'navbarTitle'	=> '#cba449',
                'navbarToggle'	=> '#cba449',
                'navbarTop'	=> '#004a40',
                'navbarSubTitle'	=> '#cba449',
                'navbarText'	=> '#ffffff',
                'navbarTopGround'	=> '#004a40',
                'navbarBottomGround'	=> '#000f0e',
                'mainBackground'	=> '#004a40',
                'mainBody'	=> '#003831',
                'mainThemeText'	=> '#cb9a44',
                'mainThemeBackground'	=> '#004d42',
                'mainThemeTextActive'	=> '#cb9a44',
                'mainThemeBackgroundActive'	=> '#004a40',
                'mainThemeBorder'	=> '#cb9a44',
                'mainCardText'	=> '#ffffff',
                'mainCardOpacity'	=> '0.6',
                'cartIcon'	=> '#cba449',
                'cartBackIcon'	=> '#004a40',
                'cartNoti'	=> '#ffffff',
                'cartBackNoti'	=> '#cc0022',
                'cartText'	=> '#cba449',
                'cartBackground'	=> '#003831',
                'cartResetText'	=> '#ffffff',
                'cartResetBackgound'	=> '#004a40',
                'cartCloseText'	=> '#ffffff',
                'cartCloseBackgound'	=> '#cc0022',
                'categoryTitle'	=> '#cba449',
                'categoryDescription'	=> '#ffffff',
                'categoryPrice'	=> '#ffffff',
                'categoryOldPrice'	=> '#cba447',
                'categoryCardBackground'	=> '#003831',
                'categoryShabow'	=> '#004a40',
                'categoryButtonText'	=> '#003831',
                'categoryButtonBackground'	=> '#cba447',
                'foodBackground'	=> '#004a40',
                'foodTitle'	=> '#bea449',
                'foodDescription'	=> '#ffffff',
                'foodPrice'	=> '#ffffff',
                'foodOldPrice'	=> '#bea449',
                'foodPriceKey'	=> '#ffffff',
                'foodPriceValue'	=> '#ffffff',
                'foodButtonText'	=> '#bea449',
                'foodButtonBackground'	=> '#003831',
                'foodImageShadow'	=> '#bea449',
                'foodImageShadowOpacity'	=> '0.1',
                'utlIconColor'	=> '#cba449',
                'utlIconBackground'	=> '#004a40',
            ],
            'p5' => [
                'startButtonText' => '#ffffff',
                'startButtonBackground' => '#090908',
                'startOpacity' => '0.3',
                'navbarTitle' => '#b22320',
                'navbarToggle' => '#b22320',
                'navbarTop' => '#090908',
                'navbarSubTitle' => '#b22320',
                'navbarText' => '#ffffff',
                'navbarTopGround' => '#090908',
                'navbarBottomGround' => '#131312',
                'mainBackground' => '#090908',
                'mainBody' => '#131312',
                'mainThemeText' => '#cb9a44',
                'mainThemeBackground' => '#131312',
                'mainThemeTextActive' => '#b12320',
                'mainThemeBackgroundActive' => '#131312',
                'mainThemeBorder' => '#b12320',
                'mainCardText' => '#ffffff',
                'mainCardOpacity' => '0.3',
                'cartIcon' => '#cba449',
                'cartBackIcon' => '#090908',
                'cartNoti' => '#ffffff',
                'cartBackNoti' => '#090908',
                'cartText' => '#ffffff',
                'cartBackground' => '#090908',
                'cartResetText' => '#ffffff',
                'cartResetBackgound' => '#653226',
                'cartCloseText' => '#ffffff',
                'cartCloseBackgound' => '#cc0022',
                'categoryTitle' => '#b22320',
                'categoryDescription' => '#ffffff',
                'categoryPrice' => '#ddb53b',
                'categoryOldPrice' => '#653226',
                'categoryCardBackground' => '#090908',
                'categoryShabow' => '#40403f',
                'categoryButtonText' => '#ffffff',
                'categoryButtonBackground' => '#653226',
                'foodBackground' => '#090908',
                'foodTitle' => '#b22320',
                'foodDescription' => '#ffffff',
                'foodPrice' => '#ffffff',
                'foodOldPrice' => '#bea449',
                'foodPriceKey' => '#ffffff',
                'foodPriceValue' => '#bea449',
                'foodButtonText' => '#ffffff',
                'foodButtonBackground' => '#653226',
                'foodImageShadow' => '#c65d5d',
                'foodImageShadowOpacity' => '0.1',
                'utlIconColor' => '#cba449',
                'utlIconBackground' => '#090908',
            ],
            'p6' => [
                'startButtonText' => '#ffffff',
                'startButtonBackground' => '#0b983a',
                'startOpacity' => '0.3',
                'navbarTitle' => '#cc0022',
                'navbarToggle' => '#0b983a',
                'navbarTop' => '#ffffff',
                'navbarSubTitle' => '#0b983a',
                'navbarText' => '#000000',
                'navbarTopGround' => '#ffffff',
                'navbarBottomGround' => '#b97e87',
                'mainBackground' => '#ffffff',
                'mainBody' => '#b8b8b8',
                'mainThemeText' => '#0b983a',
                'mainThemeBackground' => '#ffffff',
                'mainThemeTextActive' => '#cc0022',
                'mainThemeBackgroundActive' => '#ffffff',
                'mainThemeBorder' => '#cc0022',
                'mainCardText' => '#ffffff',
                'mainCardOpacity' => '0.3',
                'cartIcon' => '#ffffff',
                'cartBackIcon' => '#333234',
                'cartNoti' => '#ffffff',
                'cartBackNoti' => '#0b983a',
                'cartText' => '#000000',
                'cartBackground' => '#ffffff',
                'cartResetText' => '#ffffff',
                'cartResetBackgound' => '#0b983a',
                'cartCloseText' => '#ffffff',
                'cartCloseBackgound' => '#cc0022',
                'categoryTitle' => '#0b983a',
                'categoryDescription' => '#000000',
                'categoryPrice' => '#d69d00',
                'categoryOldPrice' => '#cc0022',
                'categoryCardBackground' => '#ffffff',
                'categoryShabow' => '#dedede',
                'categoryButtonText' => '#ffffff',
                'categoryButtonBackground' => '#cc0022',
                'foodBackground' => '#ffffff',
                'foodTitle' => '#0b983a',
                'foodDescription' => '#000000',
                'foodPrice' => '#000000',
                'foodOldPrice' => '#cc0022',
                'foodPriceKey' => '#000000',
                'foodPriceValue' => '#ffffff',
                'foodButtonText' => '#ffffff',
                'foodButtonBackground' => '#e20613',
                'foodImageShadow' => '#0b983a',
                'foodImageShadowOpacity' => '0.1',
                'utlIconColor' => '#ffffff',
                'utlIconBackground' => '#323334',
            ],
        ];

        // Check if the selected preset exists in the presets array
        if (array_key_exists($px, $presets)) {
            // Get the preset data for the selected preset
            $this->presetData = $presets[$px];


            //start group
            $this->selected_start_button_text = $this->presetData['startButtonText'] ?? '#ffffff';
            $this->selected_start_button_background = $this->presetData['startButtonBackground'] ?? '#cc0022';
            $this->selected_start_opacity = $this->presetData['startOpacity'] ?? '0.3';
            //navbar group
            $this->selected_navbar_title = $this->presetData['navbarTitle'] ?? '#cc0022';
            $this->selected_navbar_toggle = $this->presetData['navbarToggle'] ?? '#000000';
            $this->selected_navbar_top = $this->presetData['navbarTop'] ?? '#ffffff';
            $this->selected_navbar_sub_title = $this->presetData['navbarSubTitle'] ?? '#b97e87';
            $this->selected_navbar_text = $this->presetData['navbarText'] ?? '#766fa8';
            $this->selected_navbar_top_ground = $this->presetData['navbarTopGround'] ?? '#766fa8';
            $this->selected_navbar_bottom_ground = $this->presetData['navbarBottomGround'] ?? '#766fa8';
            //Main Group
            $this->selected_main_background = $this->presetData['mainBackground'] ?? '#ffffff';
            $this->selected_main_body = $this->presetData['mainBody'] ?? '#b8b8b8';
            $this->selected_main_theme_text = $this->presetData['mainThemeText'] ?? '#cc0022';
            $this->selected_main_theme_background = $this->presetData['mainThemeBackground'] ?? '#ffffff';
            $this->selected_main_theme_text_active = $this->presetData['mainThemeTextActive'] ?? '#cc0022';
            $this->selected_main_theme_background_active = $this->presetData['mainThemeBackgroundActive'] ?? '#ffffff';
            $this->selected_main_theme_border = $this->presetData['mainThemeBorder'] ?? '#cc0022';
            $this->selected_main_card_text = $this->presetData['mainCardText'] ?? '#ffffff';
            $this->selected_main_card_opacity = $this->presetData['mainCardOpacity'] ?? '0.3';
            //Cart Group
            $this->selected_cart_icon= $this->presetData['cartIcon'] ?? '#ffffff';
            $this->selected_cart_back_icon = $this->presetData['cartBackIcon'] ?? '#333234';
            $this->selected_cart_noti = $this->presetData['cartNoti'] ?? '#ffffff';
            $this->selected_cart_back_noti = $this->presetData['cartBackNoti'] ?? '#cc0022';
            $this->selected_cart_text = $this->presetData['cartText'] ?? '#000000';
            $this->selected_cart_background = $this->presetData['cartBackground'] ?? '#ffffff';
            $this->selected_cart_reset_text = $this->presetData['cartResetext'] ?? '#ffffff';
            $this->selected_cart_reset_backgound = $this->presetData['cartResetBackgound'] ?? '#cc0022';
            $this->selected_cart_close_text = $this->presetData['cartCloseText'] ?? '#ffffff';
            $this->selected_cart_close_backgound = $this->presetData['cartCloseBackgound'] ?? '#cc0022';
            //Category Group   
            $this->selected_category_title= $this->presetData['categoryTitle'] ?? '#cc0022';
            $this->selected_category_description = $this->presetData['categoryDescription'] ?? '#000000';
            $this->selected_category_price = $this->presetData['categoryPrice'] ?? '#000000';
            $this->selected_category_old_price = $this->presetData['categoryOldPrice'] ?? '#cc0022';
            $this->selected_category_card_background = $this->presetData['categoryCardBackground'] ?? '#ffffff';
            $this->selected_category_shabow = $this->presetData['categoryShabow'] ?? '#dedede';
            $this->selected_category_button_text = $this->presetData['categoryButtonText'] ?? '#ffffff';
            $this->selected_category_button_background = $this->presetData['categoryButtonBackground'] ?? '#cc0022';
            //Food Detail Group
            $this->selected_food_background = $this->presetData['foodBackground'] ?? '#ffffff';
            $this->selected_food_title = $this->presetData['foodTitle'] ?? '#cc0022';
            $this->selected_food_description = $this->presetData['foodDescription'] ?? '#000000';
            $this->selected_food_price = $this->presetData['foodPrice'] ?? '#000000';
            $this->selected_food_old_price = $this->presetData['foodOldPrice'] ?? '#cc0022';
            $this->selected_food_button_text = $this->presetData['foodPriceKey'] ?? '#000000';
            $this->selected_food_price_key = $this->presetData['foodPriceValue'] ?? '#000000';
            $this->selected_food_price_value = $this->presetData['foodButtonText'] ?? '#ffffff';
            $this->selected_food_button_background = $this->presetData['foodButtonBackground'] ?? '#cc0022';
            $this->selected_food_image_shadow = $this->presetData['foodImageShadow'] ?? '#cc0022';
            $this->selected_food_image_shadow_opacity = $this->presetData['foodImageShadowOpacity'] ?? '0.1';
            //Utilities
            $this->selected_utl_icon_color = $this->presetData['utlIconColor'] ?? '#fffff';
            $this->selected_utl_icon_background = $this->presetData['utlIconBackground'] ?? '#323334';
        } else {
            // Handle the case when the selected preset doesn't exist
            $this->presetData = ['error' => 'Preset not found'];
        }
        // dd($this->presetData);
        $this->dispatchBrowserEvent('fixedPreset', $this->presetData);
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Preset Set successfully')]);

    }
    public $objectName; 
    public $tempImg;
    public $imgReader;
    public $objectNameLogo; 
    public $tempImgLogo;
    public $imgReaderLogo;

    protected $listeners = [
        'updateCroppedHeaderImg' => 'handleCroppedImage',
        'updateCroppedLogoImg' => 'handleCroppedImageLogo',
    ];

    public function handleCroppedImage($base64data)
    {

        if ($base64data){

            $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
            $imgExsistHeader = $settings->background_img_header;
    
            if($imgExsistHeader){
                $this->imgReader = $imgExsistHeader;
            }

            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'rest/' . auth()->user()->name . '/setting/' . auth()->user()->name.'_hed_'.date('Ydm') . $microtime . '.jpeg';
            // $this->objectName = 'rest/menu/header_' . auth()->user()->name . '_'.date('Ydm').$microtime.'.jpeg';
            $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64data));
            $this->tempImg = $base64data;
            if( $this->imgReader){
                Storage::disk('s3')->delete($this->imgReader);
                Storage::disk('s3')->put($this->objectName, $croppedImage);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_img_header = $this->objectName;
                $settings->save();
            } else {
                Storage::disk('s3')->put($this->objectName, $croppedImage);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_img_header = $this->objectName;
                $settings->save();
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Image Uploaded Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...425';
        }
    }

    public function handleCroppedImageLogo($base64data)
    {
 
        if ($base64data){
            $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
            $imgExsistLogo = $settings->background_img_avatar;

            if($imgExsistLogo){
                $this->imgReaderLogo = $imgExsistLogo;
            }
            $microtime = str_replace('.', '', microtime(true));
            // $this->objectNameLogo = 'rest/menu/logo_' . auth()->user()->name . '_'.date('Ydm').$microtime.'.jpeg';
            $this->objectNameLogo = 'rest/' . auth()->user()->name . '/setting/' . auth()->user()->name.'_logo_'.date('Ydm') . $microtime . '.jpeg';
            $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64data));
            $this->tempImgLogo = $base64data;
            if( $this->imgReaderLogo){
                Storage::disk('s3')->delete($this->imgReaderLogo);
                Storage::disk('s3')->put($this->objectNameLogo, $croppedImage);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_img_avatar = $this->objectNameLogo;
                $settings->save();
            } else {
                Storage::disk('s3')->put($this->objectNameLogo, $croppedImage);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_img_avatar = $this->objectNameLogo;
                $settings->save();
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Image Uploaded Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...425';
        }
    }
}