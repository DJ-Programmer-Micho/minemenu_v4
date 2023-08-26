<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Models\Mainmenu;

class BusinessController extends Controller
{

    public function index($business_name){

        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->first();
        // $menu = Mainmenu::where('user_id', $user->id)->first();
        $ui = ['01','02','01','01'];
        // $ui = [Header, Menu, Category, Food]

        if (!$user) {
            return response('User not found', 404);
        }
       
        return view('user.index.ui-1.layouts.layout', [
            'user' => $user,
            'setting' => $setting,
            // 'menu' => $menu,
            'ui' => $ui
        ]);
    }
    public function category($business_name){

        $user = User::where('name', $business_name)->first();
        // $setting = Setting::where('user_id', $user->id)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        // $menu = Mainmenu::where('user_id', $user->id)->first();
        $ui = ['01','02','01','01'];
        // $ui = [Header, Menu, Category, Food]

        if (!$user) {
            return response('User not found', 404);
        }
    

        return view('user.index.ui-1.foods.menu_list', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            // 'menu' => $menu,
            'ui' => $ui
        ]);
    }

    public function food($business_name, $foodId){
        // return dd('1', $business_name, '2', $foodId);
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        // $menu = Mainmenu::where('user_id', $user->id)->first();
        $ui = ['01','02','01','01'];
        return view('user.index.ui-1.foods.food_list', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'foodId' => $foodId,
            'ui' => $ui
        ]);
    }

    public function foodDetail($business_name, $foodId,$detail){
        // return dd('1', $business_name, '2', $foodId);
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        // $menu = Mainmenu::where('user_id', $user->id)->first();
        $ui = ['01','02','01','01'];
        return view('user.index.ui-1.foods.food_detail', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'detail' => $detail,
            'ui' => $ui
        ]);
    }
}
