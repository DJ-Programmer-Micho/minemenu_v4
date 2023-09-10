<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;

class BusinessController extends Controller
{

    // public function index($business_name){

    //     $user = User::where('name', $business_name)->first();
    //     $setting = Setting::where('user_id', $user->id)->first();

    //     $color = json_decode($setting->default_lang);
    //     $ui = ['01','01','01','01'];
    //     // $ui = [Header, Menu, Category, Food]

    //     if (!$user) {
    //         return response('User not found', 404);
    //     }
       
    //     dd($ui);

    //     return view('user.layouts.layout', [
    //         'user' => $user,
    //         'setting' => $setting,
    //         'color' => $color,
    //         'ui' => $ui,
    //     ]);
    // }
    public function category($business_name){

        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $color = json_decode($setting->ui_color);
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        $ui = ['01','01','01','01'];
        // $ui = [Header, Menu, Category, Food]

        if (!$user) {
            return response('User not found', 404);
        }
    // dd($color);

        return view('user.layouts.menu_list', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'color' => $color,
            'ui' => $ui,
        ]);
    }

    public function food($business_name, $foodId){
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        $color = json_decode($setting->ui_color);

        $ui = ['01','01','01','01'];
        return view('user.layouts.food_list', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'foodId' => $foodId,
            'color' => $color,
            'ui' => $ui,
        ]);
    }

    public function foodDetail($business_name, $foodId,$detail){
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        $color = json_decode($setting->ui_color);
        $ui = ['01','01','01','01'];
        return view('user.layouts.food_detail', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'detail' => $detail,
            'color' => $color,
            'ui' => $ui,
        ]);
    }

    public function offerDetail($business_name ,$detail){
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        $color = json_decode($setting->ui_color);
        $ui = ['01','01','01','01'];

        return view('user.layouts.offer_detail', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'detail' => $detail,
            'color' => $color,
            'ui' => $ui,
        ]);
    }
}
