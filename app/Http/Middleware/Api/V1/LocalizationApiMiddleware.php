<?php

namespace App\Http\Middleware\Api\V1;

use Closure;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\BusinessController;
use App\Models\Subscription;

class LocalizationApiMiddleware
{
    public $selectedLanguages = ['en','ar','ku','de','it','fr','es'];

    // public function handle($request, Closure $next)
    // {
    //     try {
    //         if ($request->route('business_name')) {
    //             $businessName = $request->route('business_name');
            
    //             $userProfile = User::where('name', $businessName)->firstOrFail();
            
    //             $suspended_user_type_1 = $userProfile->status;
    //             if ($suspended_user_type_1 == 0) {
    //                 throw new \Exception("User suspended");
    //             }
            
    //             $activation = Subscription::where('user_id', $userProfile->id)
    //                 ->where('expire_at', '>=', now())
    //                 ->exists();
    //             if (!$activation) {
    //                 throw new \Exception("User subscription expired");
    //             }
            
    //             $userSettings = Setting::where('user_id', $userProfile->id)->first();
            
    //             return response()->json([
    //                 "status" => "true",
    //                 "userStatus" => [
    //                     "susbend" => 1,
    //                     "active" => 1,
    //                     "exist" => 1,
    //                 ],
    //                 "userProfile" => $userProfile,
    //                 "userSetting" => $userSettings,
    //                 "message" => "User API MW Successfully"
    //             ]);
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             "status" => "false",
    //             "message" => $e->getMessage()
    //         ]);
    //     }
    // }
    
    //     public function setLocale(Request $request)
    //     {
    //         $selectedLocale = $request->input('locale');
    
    //         // Check if the selected locale is supported
    //         if (in_array($selectedLocale, $this->selectedLanguages)) {
    //             // Store the selected language in the session
    //             $request->session()->put('locale', $selectedLocale);
    //             $request->session()->put('applocale', $selectedLocale);
    //             // Set the application locale for the current request
    //             App::setLocale($selectedLocale);
    //             // dd($selectedLocale);
    //         }
    //         return back();
    //     } // END FUNCTION

    public function handle($request, Closure $next)
    {
        try {
            if ($request->route('business_name')) {
                $businessName = $request->route('business_name');
            
                $userProfile = User::where('name', $businessName)->firstOrFail();
            
                $suspended_user_type_1 = $userProfile->status;
                if ($suspended_user_type_1 == 0) {
                    throw new \Exception("User suspended");
                }
            
                $activation = Subscription::where('user_id', $userProfile->id)
                    ->where('expire_at', '>=', now())
                    ->exists();
                if (!$activation) {
                    throw new \Exception("User subscription expired");
                }
            
                // If all conditions are met, proceed to the next middleware or route handler
                return $next($request);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "false",
                "message" => $e->getMessage()
            ]);
        }
    }

        public function setLocaleStartUp(Request $request)
        {
            $selectedLocale = $request->input('locale');
            $businessName = $request->input('businessNameHidden');
    
            // Check if the selected locale is supported
            if (in_array($selectedLocale, $this->selectedLanguages)) {
                // Store the selected language in the session
                $request->session()->put('locale', $selectedLocale);
                $request->session()->put('applocale', $selectedLocale);
                // Set the application locale for the current request
                App::setLocale($selectedLocale);
                
                $request->session()->put('ShutDown', true);
                return new RedirectResponse($businessName);
            }
            return back();
        } // END FUNCTION
}