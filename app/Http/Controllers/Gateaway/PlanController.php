<?php

namespace App\Http\Controllers\Gateaway;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Owner\TelegramPlanClicked;

class PlanController extends Controller
{ 
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

            // try {
                Notification::route('toTelegram', null)
                    ->notify(new TelegramPlanClicked(
                        $personIs,
                        $businessIs,
                        $nameIs,
                        $plan,
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