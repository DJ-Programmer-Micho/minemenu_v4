<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request; 

class BusinessController extends Controller
{

    public function startUp(Request $request, $business_name){
        $request->session()->put('ShutDown', false);
        // return $this->category($business_name); 
        return redirect($business_name);
    }

    public function category($business_name){
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $home_redirect = $setting->intro_page;

        $shutdown = session()->get('ShutDown');
        if($shutdown == true) {
            $color = json_decode($setting->ui_color);
            $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name ?? 'Restutant';
            $setting_address = $setting->translations->where('locale', app('glang'))->first()->address ?? 'Restutant';
            $ui = $setting->ui_ux;
            
            if (!$user) {
                return response('User not found', 404);
            }
            
            return view('user.layouts.menu_list', [
                'user' => $user,
                'setting' => $setting,
                'setting_name' => $setting_name,
                'setting_address' => $setting_address,
                'color' => $color,
                'ui' => $ui,
            ]);
        } else {

     
        if($home_redirect == null || $home_redirect == 0) {

            $color = json_decode($setting->ui_color);
            $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name ?? 'Restutant';
            $setting_address = $setting->translations->where('locale', app('glang'))->first()->address ?? 'Restutant';
            $ui = $setting->ui_ux;
            
            if (!$user) {
                return response('User not found', 404);
            }
            
            return view('user.layouts.menu_list', [
                'user' => $user,
                'setting' => $setting,
                'setting_name' => $setting_name,
                'setting_address' => $setting_address,
                'color' => $color,
                'ui' => $ui,
            ]);
        } else {

            $color = json_decode($setting->ui_color);
            $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name ?? 'Restutant';
            $setting_address = $setting->translations->where('locale', app('glang'))->first()->address ?? 'Restutant';
            $ui = $setting->ui_ux;
            $bg_img = $setting->background_img ?? null;
            $bg_vid = $setting->background_vid ?? null;
            
            if (!$user) {
                return response('User not found', 404);
            }
            
            return view('user.layouts.startup', [
                'user' => $user,
                'setting' => $setting,
                'setting_name' => $setting_name,
                'setting_address' => $setting_address,
                'color' => $color,
                'ui' => $ui,
                '$bg_img' => $bg_img,
                '$bg_vid' => $bg_vid,
            ]);
        }
        }
    }

    public function food($business_name, $foodId){
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name ?? 'Restutant';
        $setting_address = $setting->translations->where('locale', app('glang'))->first()->address ?? 'Restutant';
        $color = json_decode($setting->ui_color);
        $cover_id = $foodId;
         $ui = $setting->ui_ux;
        return view('user.layouts.food_list', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'setting_address' => $setting_address,
            'foodId' => $foodId,
            'color' => $color,
            'ui' => $ui,
            'cover_id' => $cover_id
        ]);
    }

    public function foodDetail($business_name, $foodId,$detail){
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name ?? 'Restutant';
        $setting_address = $setting->translations->where('locale', app('glang'))->first()->address ?? 'Restutant';
        $color = json_decode($setting->ui_color);
         $ui = json_decode($setting->ui_ux);
        return view('user.layouts.food_detail', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'setting_address' => $setting_address,
            'detail' => $detail,
            'color' => $color,
            'ui' => $ui,
        ]);
    }

    public function offerDetail($business_name ,$detail){
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name ?? 'Restutant';
        $setting_address = $setting->translations->where('locale', app('glang'))->first()->address ?? 'Restutant';
        $color = json_decode($setting->ui_color);
        $ui = json_decode($setting->ui_ux);


        return view('user.layouts.offer_detail', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'setting_address' => $setting_address,
            'detail' => $detail,
            'color' => $color,
            'ui' => $ui,
        ]);
    }
}
