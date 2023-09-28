<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\ReCaptcha;
use App\Otp\SinchService;
use Illuminate\Http\Request;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Step - 1 Display the Email Enter form
    public function showLinkRequestEmail()
    {
        return view('auth.forgetpassword.enterEmail');
    }

    // Step - 2 Check The Email If User Exist and is Active
    public function checkResetLinkEmail(Request $request)
    {
        // Validate the email address
        $request->validate([
            'email' => 'required|email',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            if($user->status == 1) {
                $otpCodeEmail = rand(100000, 999999);
                $user->email_otp_code = $otpCodeEmail;
                $user->save();
                Mail::to($user->email)->send(new EmailVerificationMail($otpCodeEmail));
                return redirect()->route('showLinkRequestEmailOtp', ['email' => urlencode($user->email)])->with('message', 'OTP sent to your email sucessfully, Please Check Your email!.');
            } else {
                return redirect()->back()->with('error', 'User not active.');
            }
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }

    // Step - 2-2 Go To Page
    public function showLinkRequestEmailOtp($encodedEmail)
    {
        $email = urldecode($encodedEmail);
        $user = User::where('email', $email)->first();

        if ($user) {
            return view('auth.forgetpassword.enterEmailOtp',['email' => urlencode($user->email)]);
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }

    // Step - 3 Go To Email OTP Page and Auto Send OTP to Email
    public function sendResetLinkEmail($encodedEmail)
    {
        $email = urldecode($encodedEmail);
        $user = User::where('email', $email)->first();

        if ($user) {
            $otpCodeEmail = rand(100000, 999999);
            $user->email_otp_code = $otpCodeEmail;
            $user->save();
            Mail::to($user->email)->send(new EmailVerificationMail($otpCodeEmail));
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }

    // Step - 4 Verify the Code
    public function verifyResetLinkEmail(Request $request)
    {
        // Verify email OTP code...
        $enteredEmailOTP = $request->input('entered_email_otp_code');
        $user = User::where('email', $request->input('email'))->first();

        if ($user && $enteredEmailOTP == $user->email_otp_code) {
            $user->email_verified = 1;
            $user->save();
            return redirect()->route('passwordRequestPhone', ['id' => urlencode($user->id)]);
        } else {
            return redirect()->back()->with('error', 'Wrong Code.');
        }
    }

    // Step - 1.1 Check The User Phone Number
    public function showLinkRequestPhone($encodedId){
        $id = urldecode($encodedId);
        $user = User::where('id', $id)->first();
        
        $maskedPhone = str_repeat('*', strlen($user->profile->phone) - 2) . substr($user->profile->phone, -2);
        return view('auth.forgetpassword.enterPhone', [
            'id' => urlencode($id),
            'maskedPhone' => $maskedPhone,
        ]);    
    } // END Function (Register)

    // Step 1.2 Check Phone Number
    public function checkResetLinkPhone(Request $request)
    {
        // Validate the email address
        $request->validate([
            'id' => 'required',
            'phone' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);

        $user = User::where('id', $request->input('id'))->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
    
        if ($user->email_verified !== 1) {
            return redirect()->back()->with('error', 'User has not verified Email.');
        }
    
        if ($user->profile->phone !== $request->input('phone')) {
            return redirect()->back()->with('error', 'Wrong phone number.');
        }
    
        return redirect()->route('showLinkRequestPhoneOtp', ['id' => urlencode($user->id)]);
        $response = SinchService::sendOTP($user->profile->phone);
    
        if ($response->successful()) {
            return redirect()->route('showLinkRequestPhoneOtp', ['id' => urlencode($user->id)]);
        } else {
            return redirect()->back()->with('error', 'Invalid SMS OTP code.');
        }
    }

    // Step - 1.2-2 Go To Page
    public function showLinkRequestPhoneOtp($encodedId)
    {
        $id = urldecode($encodedId);
        $user = User::where('id', $id)->first();

        if ($user) {
            return view('auth.forgetpassword.enterPhoneOtp',['id' => urlencode($user->id)]);
        } else {

        }
    }
    
    // Step 1.3 Send The OTP Code Via SMS
    public function sendResetLinkPhone($encodedId){
        $id = urldecode($encodedId);
        $user = User::where('id', $id)->first();
        if ($user) {
            // Send OTP via Sinch
            $response = SinchService::sendOTP($user->profile->phone);
            dd($response);
            if ($response->successful()) {
                return redirect()->route('showLinkRequestPhone', ['id'=> urlencode($id)]);
            } else {
                return redirect()->back()->with('error', 'Invalid sms OTP code.');
            }
        }
    }

    // Step 1.4 Verify the Code
    public function verifyResetLinkPhone(Request $request)
    {
        $user = User::where('id', $request->input('id'))->first();
        $enteredOTP = $request->input('entered_otp_code');
        $toNumber = $user->profile->phone;

        return  redirect()->route('passwordNewPassword', ['id'=> urlencode($user->id)])->with('message', 'Registration completed.');
        $response = SinchService::verifyOTP($toNumber, $enteredOTP);

        if ($response->successful()) {
            auth()->login($user);
            return  redirect()->route('passwordNewPassword', ['id'=> urlencode($user->id)])->with('success', 'Registration completed.');
        } else {
            return redirect()->back()->with('error', 'Invalid phone OTP code.');
        }
    }

    public function passwordNewPassword($encodedId){
        $id = urldecode($encodedId);
        return view('auth.forgetpassword.enterPassword',['id'=> urlencode($id)]);
    }

    public function passwordSendPassword(Request $request){
        $credentials = $request->validate([
            'id' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);

        if($credentials){
            $user = User::where('id', $request->input('id'))->first();
    
            if($user){
                $user->password = Hash::make($request->input('password'));
                $user->save();
            }
            return redirect('/rest')->with('success', 'Password updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong')->withInput();
        }
    }

}
