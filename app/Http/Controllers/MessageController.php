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

class MessageController extends Controller
{
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
    
        $tele_id = "-4084626386";
    
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
}
