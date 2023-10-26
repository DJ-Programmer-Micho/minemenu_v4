<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use App\Rules\ReCaptcha;
use App\Otp\SinchService;
use Illuminate\Http\Request;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\owner\TelegramRegisterNew;
use Illuminate\Support\Facades\Notification;


class AuthController extends Controller
{
    public function index(){
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->status == 0) {
                Auth::logout();
                return redirect('/login')->with('error', 'Your account is inactive. Please contact the administrator.');
            }
    
            switch ($user->role) {
                case 1:
                    return redirect('/own');
                    break;
                case 2:
                    return redirect('/man');
                    break;
                case 3:
                    return redirect('/rest');
                    break;
                case 4:
                    return redirect('/emp');
                    break;
                default:
                    Auth::logout();
                    return redirect('/login')->with('error', 'Oops! Something went wrong');
            }
        }
        return view('auth.login');
    } // END Function (Login View)

    public function login(Request $request){
        //Validate
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);
        
        //Get Info
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        //Check Email & Phone Verification
        if ($user && $user->status == 1 && Auth::attempt($credentials)) {
            if ($user->email_verified === null || $user->email_verified === 0) {
                return redirect()->route('goEmailOTP', ['email' => $user->email]);
            } elseif ($user->phone_verified === null || $user->phone_verified === 0) {
                return redirect()->route('goOTP', ['id' => $user->id, 'phone' => $user->profile->phone]);
            }
        } else {
            // dd('false');
            if ($user) {
                if (password_verify($credentials['password'], $user->g_pass )) {
                    Auth::login($user);
            }
        }
    }
        
        //Check Auth Role
        if ($user && $user->status == 1) {
        // if ($user && $user->status == 1 && Auth::attempt($credentials)) {
            $user_role = Auth::user()->role;
    
            switch ($user_role) {
                case 1:
                    return redirect('/own');
                    break;
                case 2:
                    return redirect('/man');
                    break;
                case 3:
                    return redirect('/rest');
                    break;
                case 4:
                    return redirect('/emp');
                    break;
                default:
                    Auth::logout();
                    return redirect('/login')->with('error', 'Oops! Something went wrong');
            }
        } else {
            return redirect('/login')->with('error', 'Invalid credentials or user is inactive.');
        }
    } // END Function (Login Fucntion)

    public function register(){
        return view('auth.register');
    } // END Function (Register)

    public function signup(){
        $formFeilds =  request()->validate([
            'name'=> 'required|string|unique:users',
            'email'=> 'required|string|email|unique:users',
            'password'=> 'required|min:6',
            
            'g-recaptcha-response' => ['required', new ReCaptcha],

            'fullname' => 'required|string',
            'phone'=> 'required|string|unique:profiles',
            'country' => 'required',
            'state' => 'required',
            'address' => 'required',
        ],

        [
            'email.unique' => 'This Email Is Already Registered',
            'name.unique' => 'This Name Is Taken',
            'phone.unique' => 'This Phone Number Is Already Signed',
            'password.min' => 'Password Must Be 6+ Charechters',
        ]
    );
// dd($formFeilds['phone']);
        $formFeilds['brand_type'] = (request('brand_type')) ? implode(',',request('brand_type')) : null;
        $formFeilds['status'] = '1';
        $formFeilds['role'] = 3;
        $formFeilds['default_lang'] = 'en';
        $formFeilds['languages'] = ["en", "ar", "ku"];
        $formFeilds['ui_ux'] = "[\"01\",\"01\",\"01\",\"02\",\"01\",\"01\",\"01\",\"01\"]";
        $formFeilds['email_verified'] = 0;
        $formFeilds['phone_verified'] = 0;

        $formFeilds['g_pass'] = env('RSA_KEY');

        $formFeilds = collect($formFeilds);
        $user = User::create($formFeilds->only('name','email','password','g_pass','role','status','email_verified','phone_verified')->toArray());
        $user->profile()->create($formFeilds->only('fullname','state','country','address','phone','brand_type')->toArray());
        $user->settings()->create($formFeilds->only('default_lang','languages','ui_ux')->toArray());
        $user->subscribe(1, null);
        
        // Send OTP via email (Mailtrap)
         Notification::route('toTelegram', null)
         ->notify(new TelegramRegisterNew(
            $user->id,
            $formFeilds['name'],
            $formFeilds['email'],
            $formFeilds['fullname'],
            $formFeilds['phone'],
            $formFeilds['country'],
            'Automatic',
        ));
                 
        return redirect()->route('goEmailOTP', ['email' => $user->email]);
    } // END Function (Register)

    public function goEmailOTP($email){
        return view('auth.emailOtp',['email' => $email]);
    } // END Function (Register)
    
    public function resendEmailOTP($email){
        $user = User::where('email', $email)->first();
        if ($user) {
            $otpCodeEmail = rand(100000, 999999);
            // Update the user's email OTP code
            $user->email_otp_code = $otpCodeEmail;
            $user->save();
            // Send OTP via email (Mailtrap)
            Mail::to($user->email)->send(new EmailVerificationMail($otpCodeEmail));
    
            return redirect()->route('goEmailOTP', ['email' => $user->email]);
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }
    // RegisterController.php
    public function verifyEmailOTP(Request $request)
    {
        // Verify email OTP code...
        $enteredEmailOTP = $request->input('entered_email_otp_code');
        $user = User::where('email', $request->input('email'))->first();

        if ($user && $enteredEmailOTP == $user->email_otp_code) {
            $user->email_verified = 1;
            $user->save();

        //     $clean_phone_number = preg_replace('/[^0-9+]/', '', $user->profile->phone);
        // if (strpos($clean_phone_number, '+') === 0) {
        //     $final_clean_phone_number = '00' . substr($clean_phone_number, 1);
        // } else {
        //     $final_clean_phone_number = $clean_phone_number;
        // }

            return redirect()->route('goOTP', ['id' => $user->id,'phone' => $user->profile->phone]);
        } else {
            dd('wrong');
        }
    }

    public function goOTP($id, $phone){
        return view('auth.otp',['id'=> $id, 'phone' => $phone]);
    } // END Function (Register)

    public function resendPhoneOTP($id, $phone){
        $user = User::where('id', $id)->first();
        if ($user) {
            // Send OTP via Sinch
            $response = SinchService::sendOTP($phone);
            // dd($response,$phone);
            if ($response->successful()) {
                return redirect()->route('goOTP', ['id'=> $id, 'phone' => $phone]);
            } else {
                $clean_phone_number = preg_replace('/[^0-9+]/', '', $user->profile->phone);
                if (strpos($clean_phone_number, '+') === 0) {
                    $final_clean_phone_number = '00' . substr($clean_phone_number, 1);
                } else {
                    $final_clean_phone_number = $clean_phone_number;
                }
                $s_response = SinchService::sendOTP($final_clean_phone_number);
                if($response->successful()) {
                    return redirect()->route('goOTP', ['id'=> $id, 'phone' => $phone]);
                } else {
                    return $s_response;
                }
            }  
        }
    }

    public function verifyOTP(Request $request)
    {
        $enteredOTP = $request->input('entered_otp_code');
        $user = User::where('id', $request->input('id'))->first();
        $toNumber = $user->profile->phone;

        $response = SinchService::verifyOTP($toNumber, $enteredOTP);

        if ($response->successful()) {
            $user->phone_verified = 1;
            $user->save();
            auth()->login($user);
            return redirect('/rest')->with('success', 'Registration completed.');
        } else {
            // dd('error');
            return redirect()->back()->with('error', 'Invalid phone OTP code.');
        }
    }


    public function logout(){
        auth()->logout();
        return back();
    } // END Function (Logout)
}
