<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\ReCaptcha;


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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);
        

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if ($user && $user->status == 1 && Auth::attempt($credentials)) {
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

        $formFeilds['brand_type'] = (request('brand_type')) ? implode(',',request('brand_type')) : null;
        $formFeilds['status'] = '1';
        $formFeilds['role'] = 3;
        $formFeilds['default_lang'] = 'en';
        $formFeilds['languages'] = ["en", "ar", "ku"];
        $formFeilds['ui_ux'] = "[\"03\",\"01\",\"03\",\"02\",\"07\",\"03\",\"01\",\"03\"]";

        $formFeilds = collect($formFeilds);
        
        $user = User::create($formFeilds->only('name','email','password','role','status')->toArray());
        $user->profile()->create($formFeilds->only('fullname','state','country','address','phone','brand_type')->toArray());
        $user->settings()->create($formFeilds->only('default_lang','languages','ui_ux')->toArray());
        auth()->login($user);
        return redirect('/rest');
    } // END Function (Register)

    public function logout(){
        auth()->logout();
        return back();
    } // END Function (Logout)
}
