<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Config;
use App\Notifications\TelegramNewRegister;
use App\Notifications\TelegramContactUs;

class MessageController extends Controller
{
    // use Notifiable;

    public function contactUsApp(Request $request){
        // dd($request->all());
            $name = $request->name;
            $email = $request->email;
            $message = $request->message;
     

        Notification::route('toTelegram', env('TELEGRAM_GROUP_ID'))
        ->notify(new TelegramContactUs($name,$email,$message));



        return redirect()->back();
    }
}
