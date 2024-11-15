<?php

namespace App\Http\Controllers\Gateaway;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Owner\TelegramPlanClicked;
use Stevebauman\Location\Facades\Location;

class PlanController extends Controller
{ 
    public $location;
    public $guestIdentifier;
    public $deviceIdentifier;

    public function show(Plan $id){
        if (!$id->valid_date || $id->valid_date >= now()) {
            $plan = $id;
            $tele_id = env('TELEGRAM_GROUP_ID_PLAN_REGISTER');

            if(Auth::check()){
                $personIs = 'Register';
                $businessIs = auth()->user()->name;
                $nameIs = auth()->user()->profile->fullname;
            } else {
                $personIs = 'Visitor';
                $businessIs = 'unKnown';
                $nameIs = 'unKnown';
            }

            try {
                $ip = request()->ip();
                $url = "https://ipinfo.io/{$ip}/json";
                $data = json_decode(file_get_contents($url));
                // Check if the 'country' property exists in the response
                $userCountry = isset($data->country) ? $data->country : 'N/A';
            } catch (\Exception $e) {
                //nothing
            }

            try {

                $this->guestIdentifier = $_SERVER['REMOTE_ADDR'];
                // $this->guestIdentifier = '130.193.228.71';
                try {
                    $this->location = Location::get($this->guestIdentifier);
                } catch (\Exception $e) {
    
                }
                $this->deviceIdentifier = $_SERVER['HTTP_USER_AGENT'];
            }
            catch (\Exception $e) {
                
            }

            // try {
                Notification::route('toTelegram', null)
                    ->notify(new TelegramPlanClicked(
                        $personIs,
                        $businessIs,
                        $nameIs,
                        $plan,
                        $userCountry,
                        $this->location,
                        $this->guestIdentifier,
                        $this->deviceIdentifier,
                        $tele_id
                    ));
        
                // return redirect()->back()->with('alert', [
                //     'type' => 'success',
                //     'message' => __('Message sent successfully'),
                // ]);
            // } catch (\Exception $e) {
                // return redirect()->back()->with('alert', [
                //     'type' => 'error',
                //     'message' => __('An error occurred while sending the notification.'),
                // ]);
            // }


        } else {
            // return redirect('home');
            return 'HA Expire';
        }
        return view('main.plan.show',compact('plan'));
    }
}