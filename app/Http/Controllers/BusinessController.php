<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Gloudemans\Shoppingcart\Facades\Cart;


class BusinessController extends Controller
{

    public function index($business_name){

        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->first();
        // $cart_count = Cart::content()->count();
        $ui = ['01','01','01','01'];
        // $ui = [Header, Menu, Category, Food]

        if (!$user) {
            return response('User not found', 404);
        }
       
        

        return view('user.layouts.layout', [
            'user' => $user,
            'setting' => $setting,
            'ui' => $ui,
            // 'cart_count' => $cart_count
        ]);
    }
    public function category($business_name){

        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        // $cart_count = Cart::content()->count();
        $ui = ['01','01','01','01'];
        // $ui = [Header, Menu, Category, Food]

        if (!$user) {
            return response('User not found', 404);
        }
    

        return view('user.layouts.menu_list', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'ui' => $ui,
            // 'cart_count' => $cart_count
        ]);
    }

    public function food($business_name, $foodId){
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        // $cart_count = Cart::content()->count();
        $ui = ['01','01','01','01'];
        return view('user.layouts.food_list', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'foodId' => $foodId,
            'ui' => $ui,
            // 'cart_count' => $cart_count
        ]);
    }

    public function foodDetail($business_name, $foodId,$detail){
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        // $cart_count = Cart::content()->count();
        $ui = ['01','01','01','01'];
        return view('user.layouts.food_detail', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'detail' => $detail,
            'ui' => $ui,
            // 'cart_count' => $cart_count
        ]);
    }

    public function offerDetail($business_name, $offerId,$detail){
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name;
        // $cart_count = Cart::content()->count();
        $ui = ['01','01','01','01'];
        return view('user.layouts.food_detail', [
            'user' => $user,
            'setting' => $setting,
            'setting_name' => $setting_name,
            'detail' => $detail,
            'ui' => $ui,
            // 'cart_count' => $cart_count
        ]);
    }
}
