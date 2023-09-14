<?php
 
namespace App\Http\Livewire\dashboard;

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
        $imgExsistHeader = $settings->background_img;
        $imgExsistLogo = $settings->background_vid;

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
        // return view('dashboard.livewire.design-customize-form');
        return view('dashboard.livewire.design-customize-form', ['user_color' => $this->user_color]);
    }


    public function saveColors(){

        $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
        $settings->ui_color = [
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
            'selectedCategoryButtonText' => $this->selected_category_button_text ?? '#ffff00',
            'selectedCategoryButtonBackground' => $this->selected_category_button_background ?? '#ffff00',
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
            'selectedUtlIconBackground' => $this->selected_utl_icon_background ?? '#ff0022',

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
            'selectedCategoryButtonText' => $this->selected_category_button_text ?? '#ffff00',
            'selectedCategoryButtonBackground' => $this->selected_category_button_background ?? '#ffff00',
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
            'selectedUtlIconBackground' => $this->selected_utl_icon_background ?? '#ff0022',
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
            'selectedCategoryButtonText' => $this->selected_category_button_text ?? '#ffff00',
            'selectedCategoryButtonBackground' => $this->selected_category_button_background ?? '#ffff00',
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
            'selectedUtlIconBackground' => $this->selected_utl_icon_background ?? '#ff0022',
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
            //NAVBAR GROUP
            $this->selected_navbar_title = $user_color['selectedNavbarTitle'] ?? '#ffff00';
            $this->selected_navbar_toggle = $user_color['selectedNavbarToggle'] ?? '#766fa8';
            $this->selected_navbar_top = $user_color['selectedNavbarTop'] ?? '#766fa8';
            $this->selected_navbar_sub_title = $user_color['selectedNavbarSubTitle'] ?? '#766fa8';
            $this->selected_navbar_text = $user_color['selectedNavbarText'] ?? '#766fa8';
            $this->selected_navbar_top_ground = $user_color['selectedNavbarTopGround'] ?? '#766fa8';
            $this->selected_navbar_bottom_ground = $user_color['selectedNavbarBottomGround'] ?? '#766fa8';
            //Main Group
            $this->selected_main_background = $user_color['selectedMainBackground'] ?? '#ffff00';
            $this->selected_main_body = $user_color['selectedMainBody'] ?? '#ffff00';
            $this->selected_main_theme_text = $user_color['selectedMainThemeText'] ?? '#ffff00';
            $this->selected_main_theme_background = $user_color['selectedMainThemeBackgroud'] ?? '#ffff00';
            $this->selected_main_theme_text_active = $user_color['selectedMainThemeTextActive'] ?? '#ffff00';
            $this->selected_main_theme_background_active = $user_color['selectedMainThemeBackgroudActive'] ?? '#ffff00';
            $this->selected_main_theme_border = $user_color['selectedMainThemeBorder'] ?? '#ffff00';
            $this->selected_main_card_opacity = $user_color['selectedMainCardOpacity'] ?? '#ffff00';
            $this->selected_main_card_text = $user_color['selectedMainCardText'] ?? '#ffff00';
            //Cart Group
            $this->selected_cart_icon= $user_color['selectedCartIcon'] ?? '#ffff00';
            $this->selected_cart_back_icon = $user_color['selectedCartBackIcon'] ?? '#ffff00';
            $this->selected_cart_noti = $user_color['selectedCartNoti'] ?? '#ffff00';
            $this->selected_cart_back_noti = $user_color['selectedCartBackNoti'] ?? '#ffff00';
            $this->selected_cart_text = $user_color['selectedCartText'] ?? '#ffff00';
            $this->selected_cart_background = $user_color['selectedCartBackground'] ?? '#ffff00';
            $this->selected_cart_reset_text = $user_color['selectedCartResetText'] ?? '#ffff00';
            $this->selected_cart_reset_backgound = $user_color['selectedCartResetBackgound'] ?? '#ffff00';
            $this->selected_cart_close_text = $user_color['selectedCartCloseText'] ?? '#ffff00';
            $this->selected_cart_close_backgound = $user_color['selectedCartCloseBackgound'] ?? '#ffff00';
            //Category Group   
            $this->selected_category_title= $user_color['selectedCategoryTitle'] ?? '#ffff00';
            $this->selected_category_description = $user_color['selectedCategoryDescription'] ?? '#ffff00';
            $this->selected_category_price = $user_color['selectedCategoryPrice'] ?? '#ffff00';
            $this->selected_category_old_price = $user_color['selectedCategoryOldPrice'] ?? '#ffff00';
            $this->selected_category_card_background = $user_color['selectedCategoryCardBackground'] ?? '#ffff00';
            $this->selected_category_shabow = $user_color['selectedCategoryShabow'] ?? '#ffff00';
            $this->selected_category_button_text = $user_color['selectedCategoryButtonText'] ?? '#ffff00';
            $this->selected_category_button_background = $user_color['selectedCategoryButtonBackground'] ?? '#ffff00';
            //Food Detail Group
            $this->selected_food_background = $user_color['selectedFoodBackground'] ?? '#ffff00';
            $this->selected_food_title = $user_color['selectedFoodTitle'] ?? '#ffff00';
            $this->selected_food_description = $user_color['selectedFoodDescription'] ?? '#ffff00';
            $this->selected_food_price = $user_color['selectedFoodPrice'] ?? '#ffff00';
            $this->selected_food_old_price = $user_color['selectedFoodOldPrice'] ?? '#ffff00';
            $this->selected_food_button_text = $user_color['selectedFoodButtonText'] ?? '#ffff00';
            $this->selected_food_price_key = $user_color['selectedFoodPriceKey'] ?? '#ffff00';
            $this->selected_food_price_value = $user_color['selectedFoodPriceValue'] ?? '#ffff00';
            $this->selected_food_button_background = $user_color['selectedFoodButtonBackground'] ?? '#ffff00';
            $this->selected_food_image_shadow = $user_color['selectedFoodImageShadow'] ?? '#ffff00';
            $this->selected_food_image_shadow_opacity = $user_color['selectedFoodImageShadowOpacity'] ?? '#ffff00';
            //Utilities
            $this->selected_utl_icon_color = $user_color['selectedUtlIconColor'] ?? '#ffff00';
            $this->selected_utl_icon_background = $user_color['selectedUtlIconBackground'] ?? '#ffff00';
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
                'navbarTitle' => '#ffffff',
                'navbarToggle' => '#cc0022',
                'navbarTop' => '#e3e3e3',
                'navbarSubTitle' => '#cc0022',
                'navbarText' => '#b00000',
                'navbarTopGround' => '#ebebeb',
                'navbarBottomGround' => '#000000',
                'mainBackground' => '#4d4d4d',
                'mainBody' => '#000000',
                'mainThemeText' => '#ebebeb',
                'mainThemeBackground' => '#ffffff',
                'mainThemeTextActive' => '#cc0022',
                'mainThemeBackgroundActive' => '#ffffff',
                'mainThemeBorder' => '#cc0022',
                'mainCardText' => '#ffffff',
                'mainCardOpacity' => '0.25',
                'cartIcon' => '#cc0022',
                'cartBackIcon' => '#cc0022',
                'cartNoti' => '#cc0022',
                'cartBackNoti' => '#cc0022',
                'cartText' => '#cc0022',
                'cartBackground' => '#cc0022',
                'cartResetext' => '#cc0022',
                'cartResetBackgound' => '#cc0022',
                'cartCloseText' => '#cc0022',
                'cartCloseBackgound' => '#cc0022',
                'categoryTitle' => '#cc0022',
                'categoryDescription' => '#cc0022',
                'categoryPrice' => '#cc0022',
                'categoryOldPrice' => '#cc0022',
                'categoryCardBackground' => '#cc0022',
                'categoryShabow' => '#cc0022',
                'categoryButtonText' => '#cc0022',
                'categoryButtonBackground' => '#cc0022',
                'foodBackground' => '#cc0022',
                'foodTitle' => '#cc0022',
                'foodDescription' => '#cc0022',
                'foodPrice' => '#cc0022',
                'foodOldPrice' => '#cc0022',
                'foodPriceKey' => '#cc0022',
                'foodPriceValue' => '#cc0022',
                'foodButtonText' => '#cc0022',
                'foodButtonBackground' => '#cc0022',
                'foodImageShadow' => '#cc0022',
                'foodImageShadowOpacity' => '0.9',
                'utlIconColor' => '#cc0022',
                'utlIconBackground' => '#cc0022',
            ],
            'p2' => [
                'navbarTitle' => '#fffaaa',
                'navbarToggle' => '#fffaaa',
                'navbarTop' => '#e3eaaa',
                'navbarSubTitle' => '#cc0aaa',
                'navbarText' => '#b00aaa',
                'navbarTopGround' => '#ebeaaa',
                'navbarBottomGround' => '#000aaa',
                'mainBackground' => '#4d4aaa',
                'mainBody' => '#000aaa',
                'mainThemeText' => '#ebeaaa',
                'mainThemeBackground' => '#fffaaa',
                'mainThemeTextActive' => '#cc0aaa',
                'mainThemeBackgroundActive' => '#fffaaa',
                'mainThemeBorder' => '#cc0aaa',
                'mainCardText' => '#fffaaa',
                'mainCardOpacity' => '0.25',
                'cartIcon' => '#cc0aaa',
                'cartBackIcon' => '#cc0aaa',
                'cartNoti' => '#cc0aaa',
                'cartBackNoti' => '#cc0aaa',
                'cartText' => '#cc0aaa',
                'cartBackground' => '#cc0aaa',
                'cartResetext' => '#cc0aaa',
                'cartResetBackgound' => '#cc0aaa',
                'cartCloseText' => '#cc0aaa',
                'cartCloseBackgound' => '#cc0aaa',
                'categoryTitle' => '#cc0aaa',
                'categoryDescription' => '#cc0aaa',
                'categoryPrice' => '#cc0aaa',
                'categoryOldPrice' => '#cc0aaa',
                'categoryCardBackground' => '#cc0aaa',
                'categoryShabow' => '#cc0aaa',
                'categoryButtonText' => '#ff0022',
                'categoryButtonBackground' => '#ff0022',
                'foodBackground' => '#cc0aaa',
                'foodTitle' => '#cc0aaa',
                'foodDescription' => '#cc0aaa',
                'foodPrice' => '#cc0aaa',
                'foodOldPrice' => '#cc0aaa',
                'foodPriceKey' => '#cc0aaa',
                'foodPriceValue' => '#cc0aaa',
                'foodButtonText' => '#cc0aaa',
                'foodButtonBackground' => '#cc0aaa',
                'foodImageShadow' => '#cc0aaa',
                'foodImageShadowOpacity' => '0.9',
                'utlIconColor' => '#cc0aaa',
                'utlIconBackground' => '#cc0aaa',
            ],
        ];

        // Check if the selected preset exists in the presets array
        if (array_key_exists($px, $presets)) {
            // Get the preset data for the selected preset
            $this->presetData = $presets[$px];


            $this->selected_navbar_title = $this->presetData['navbarTitle'] ?? '#aa3300';
            $this->selected_navbar_toggle = $this->presetData['navbarToggle'] ?? '#766fa8';
            $this->selected_navbar_top = $this->presetData['navbarTop'] ?? '#766fa8';
            $this->selected_navbar_sub_title = $this->presetData['navbarSubTitle'] ?? '#766fa8';
            $this->selected_navbar_text = $this->presetData['navbarText'] ?? '#766fa8';
            $this->selected_navbar_top_ground = $this->presetData['navbarTopGround'] ?? '#766fa8';
            $this->selected_navbar_bottom_ground = $this->presetData['navbarBottomGround'] ?? '#766fa8';
            //Main Group
            $this->selected_main_background = $this->presetData['mainBackground'] ?? '#ffff00';
            $this->selected_main_body = $this->presetData['mainBody'] ?? '#ffff00';
            $this->selected_main_theme_text = $this->presetData['mainThemeText'] ?? '#ffff00';
            $this->selected_main_theme_background = $this->presetData['mainThemeBackground'] ?? '#ffff00';
            $this->selected_main_theme_text_active = $this->presetData['mainThemeTextActive'] ?? '#ffff00';
            $this->selected_main_theme_background_active = $this->presetData['mainThemeBackgroundActive'] ?? '#ffff00';
            $this->selected_main_theme_border = $this->presetData['mainThemeBorder'] ?? '#ffff00';
            $this->selected_main_card_opacity = $this->presetData['mainCardText'] ?? '#ffff00';
            $this->selected_main_card_text = $this->presetData['mainCardOpacity'] ?? '#ffff00';
            //Cart Group
            $this->selected_cart_icon= $this->presetData['cartIcon'] ?? '#ffff00';
            $this->selected_cart_back_icon = $this->presetData['cartBackIcon'] ?? '#ffff00';
            $this->selected_cart_noti = $this->presetData['cartNoti'] ?? '#ffff00';
            $this->selected_cart_back_noti = $this->presetData['cartBackNoti'] ?? '#ffff00';
            $this->selected_cart_text = $this->presetData['cartText'] ?? '#ffff00';
            $this->selected_cart_background = $this->presetData['cartBackground'] ?? '#ffff00';
            $this->selected_cart_reset_text = $this->presetData['cartResetext'] ?? '#ffff00';
            $this->selected_cart_reset_backgound = $this->presetData['cartResetBackgound'] ?? '#ffff00';
            $this->selected_cart_close_text = $this->presetData['cartCloseText'] ?? '#ffff00';
            $this->selected_cart_close_backgound = $this->presetData['cartCloseBackgound'] ?? '#ffff00';
            //Category Group   
            $this->selected_category_title= $this->presetData['categoryTitle'] ?? '#ffff00';
            $this->selected_category_description = $this->presetData['categoryDescription'] ?? '#ffff00';
            $this->selected_category_price = $this->presetData['categoryPrice'] ?? '#ffff00';
            $this->selected_category_old_price = $this->presetData['categoryOldPrice'] ?? '#ffff00';
            $this->selected_category_card_background = $this->presetData['categoryCardBackground'] ?? '#ffff00';
            $this->selected_category_shabow = $this->presetData['categoryShabow'] ?? '#ffff00';
            $this->selected_category_button_text = $this->presetData['categoryButtonText'] ?? '#ffff00';
            $this->selected_category_button_background = $this->presetData['categoryButtonBackground'] ?? '#ffff00';
            //Food Detail Group
            $this->selected_food_background = $this->presetData['foodBackground'] ?? '#ffff00';
            $this->selected_food_title = $this->presetData['foodTitle'] ?? '#ffff00';
            $this->selected_food_description = $this->presetData['foodDescription'] ?? '#ffff00';
            $this->selected_food_price = $this->presetData['foodPrice'] ?? '#ffff00';
            $this->selected_food_old_price = $this->presetData['foodOldPrice'] ?? '#ffff00';
            $this->selected_food_button_text = $this->presetData['foodPriceKey'] ?? '#ffff00';
            $this->selected_food_price_key = $this->presetData['foodPriceValue'] ?? '#ffff00';
            $this->selected_food_price_value = $this->presetData['foodButtonText'] ?? '#ffff00';
            $this->selected_food_button_background = $this->presetData['foodButtonBackground'] ?? '#ffff00';
            $this->selected_food_image_shadow = $this->presetData['foodImageShadow'] ?? '#ffff00';
            $this->selected_food_image_shadow_opacity = $this->presetData['foodImageShadowOpacity'] ?? '#ffff00';
            //Utilities
            $this->selected_utl_icon_color = $this->presetData['utlIconColor'] ?? '#ffff00';
            $this->selected_utl_icon_background = $this->presetData['utlIconBackground'] ?? '#ffff00';
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
            $microtime = str_replace('.', '', microtime(true));
            $this->objectName = 'rest/menu/header_' . auth()->user()->name . '_'.date('Ydm').$microtime.'.jpeg';
            $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64data));
            $this->tempImg = $base64data;
            if( $this->imgReader){
                Storage::disk('s3')->delete($this->imgReader);
                Storage::disk('s3')->put($this->objectName, $croppedImage);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_img = $this->objectName;
                $settings->save();
            } else {
                Storage::disk('s3')->put($this->objectName, $croppedImage);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_img = $this->objectName;
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
            $microtime = str_replace('.', '', microtime(true));
            $this->objectNameLogo = 'rest/menu/logo_' . auth()->user()->name . '_'.date('Ydm').$microtime.'.jpeg';
            $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64data));
            $this->tempImgLogo = $base64data;
            if( $this->imgReaderLogo){
                Storage::disk('s3')->delete($this->imgReaderLogo);
                Storage::disk('s3')->put($this->objectNameLogo, $croppedImage);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_vid = $this->objectNameLogo;
                $settings->save();
            } else {
                Storage::disk('s3')->put($this->objectNameLogo, $croppedImage);
                $settings = Setting::firstOrNew(['user_id' => auth()->id()]);
                $settings->background_vid = $this->objectNameLogo;
                $settings->save();
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => __('Image Uploaded Successfully')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => __('Image did not crop!!!')]);
            return 'failed to crop image code...425';
        }
    }
}

