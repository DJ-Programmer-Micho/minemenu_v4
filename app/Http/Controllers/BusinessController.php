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

    public function generateManifest($business_name)
    {
        // Fetch business-specific information (e.g., from your database)
        $user = User::where('name', $business_name)->first();
        $setting = Setting::where('user_id', $user->id)->with('translations')->first();
        $setting_name = $setting->translations->where('locale', app('glang'))->first()->rest_name ?? 'Restutant';
        $color = json_decode($setting->ui_color);

        if (!$user || !$setting) {
            abort(404); // Handle cases where the user or setting is not found
        }
        // Generate the dynamic manifest data based on $businessInfo
        $manifestData = [
            'name' => $setting_name,
            'short_name' => $setting_name,
            'icons' => [
                [
                    "src" => app('cloudfront').$setting->background_img_avatar,
                    "type" => "image/svg+xml",
                    "sizes" => "256x256"
                ]
                ],
            "id"=> "http://" . $business_name . "?source=pwa",
            "start_url"=> "http://" . $business_name . "?source=pwa",
            "background_color"=> app('cloudfront').$color->selectedMainBackground ?? '#ffffff',
            "display"=> "fullscreen",
            // "display"=> "standalone",
            "scope"=> "/",
            "theme_color"=> $color->selectedNavbarTop ?? '#ffffff',
            "shortcuts"=> [
                [
                  "name"=> "Check The New Update",
                  "short_name"=> "Update",
                  "description"=> "Join To Mine Mneu NOW!",
                  "url"=> "http://192.168.0.80:8000?source=pwa",
                  "icons"=> [[ "src"=> app('cloudfront').$setting->background_img_header, "sizes"=> "192x192" ]]
                ],
                [
                  "name"=> "Get Menu For 14 Days Free Trial",
                  "short_name"=> "FREE MENU",
                  "description"=> "Register to the free menu",
                  "url"=> "http://192.168.0.80:8000/pricing?source=pwa",
                  "icons"=> [[ "src"=> app('cloudfront').$setting->background_img_header, "sizes"=> "192x192" ]]
                ]
              ],
        ];

        // Return the manifest data as JSON
        return response()->json($manifestData); 
    }
}
