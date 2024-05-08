<?php 

namespace App\Http\Controllers\Api\V1;

use Livewire\Livewire;
use App\Models\Mainmenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Dashboard\MainMenuLivewire;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Config;
use App\Notifications\TelegramNewRegister;
// use App\Notifications\TelegramContactUs;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Owner\TelegramContactUs;
use Stevebauman\Location\Facades\Location;


class ContactUsViaApp extends Controller
{
    public $location;
    public $guestIdentifier;
    public $deviceIdentifier;
    public function contactUsViaApp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // $tele_id = "-1002046515204";
        $tele_id = env('TELEGRAM_GROUP_ID_CONTACT_US');
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
        try {
            Notification::route('toTelegram', null)
                ->notify(new TelegramContactUs(
                    'visiter',
                    '',
                    $request->input('name'),
                    $request->input('email'),
                    '',
                    $request->input('message'),
                    $request->input('phone'),
                    $this->location,
                    $this->guestIdentifier,
                    $this->deviceIdentifier,
                    $tele_id
                ));
    
            return response()->json([
                'type' => 'success',
                'message' => __('Message sent successfully'),
            ], 200);  
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => __('Message did not send successfully'),
            ], 404); 
        }
    }
}
