<?php

namespace App\Http\Controllers;


use App\Models\User;
use Livewire\Livewire;
use App\Models\Setting;
use App\Models\Mainmenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function index($business_name){

        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->first();
        $menu = Mainmenu::where('user_id', $user->id)->first();

        if (!$user) {
            return response('User not found', 404);
        }

        // Get the user ID
        $userId = $user->id;

        // Livewire::component('user.components.cat01-component', ['restName' => $user]);

        // return "User ID for business_name '{$business_name}': {$userId}";
        // return view('user.index.ui-1.layouts.m', ['data' => $user]);
        return view('user.index.ui-1.layouts.layout', [
            'data' => $user,
            'setting' => $setting,
            'menu' => $menu
        ]);
    }
}
