<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Config;
use App\Notifications\TelegramNewRegister;
// use App\Notifications\TelegramContactUs;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Owner\TelegramContactUs;
use Stevebauman\Location\Facades\Location;

class MessageController extends Controller
{
    public $location;
    public $guestIdentifier;
    public $deviceIdentifier;
    // use Notifiable;
    public function contactUsApp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $tele_id = "-1002046515204";
        $tele_id = env('TELEGRAM_GROUP_ID_CONTACT_US');
        try {

            $this->guestIdentifier = $_SERVER['REMOTE_ADDR'];
            try {
                $this->location = Location::get($this->guestIdentifier);
            } catch (\Exception $e) {

            }
            $this->deviceIdentifier = $_SERVER['HTTP_USER_AGENT'];
        }
        catch (\Exception $e) {
            
        }
        try {
            Notification::route('toTelegram', null)
                ->notify(new TelegramContactUs(
                    'visiter',
                    '',
                    $request->input('name'),
                    $request->input('email'),
                    '',
                    $request->input('message'),
                    '',
                    $this->location,
                    $this->guestIdentifier,
                    $this->deviceIdentifier,
                    $tele_id
                ));
    
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => __('Message sent successfully'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => __('An error occurred while sending the notification.'),
            ]);
        }
    }

    // public function contactUsViaApp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'phone' => 'required',
    //         'message' => 'required',
    //     ]);
    
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }
    
    //     // $tele_id = "-1002046515204";
    //     $tele_id = env('TELEGRAM_GROUP_ID_CONTACT_US');
    
    //     try {
    //         Notification::route('toTelegram', null)
    //             ->notify(new TelegramContactUs(
    //                 'visiter',
    //                 '',
    //                 $request->input('name'),
    //                 $request->input('email'),
    //                 '',
    //                 $request->input('message'),
    //                 $request->input('phone'),
    //                 $tele_id
    //             ));
    
    //         return redirect()->back()->with('alert', [
    //             'type' => 'success',
    //             'message' => __('Message sent successfully'),
    //         ]);
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('alert', [
    //             'type' => 'error',
    //             'message' => __('An error occurred while sending the notification.'),
    //         ]);
    //     }
    // }
}
