<?php

namespace App\Http\Controllers\Api\V1;

// use App\Models\Food;
use App\Models\User;
// use App\Models\Mainmenu;
// use App\Rules\ReCaptcha;
// use App\Otp\SinchService;
// use App\Models\Categories;
// use App\Models\PlanChange;
use App\Models\PlanChange;
// use App\Models\Food_Translator;
// use App\Mail\EmailVerificationMail;
// use App\Models\Mainmenu_Translator;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;
// use App\Models\Categories_Translator;
// use Illuminate\Support\Facades\Notification;
// use App\Notifications\Owner\TelegramRegisterNew;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Notifications\Owner\TelegramRegisterNew;

class AuthApiController extends Controller
{
    use HasApiTokens;

    public function login(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);
    
        // Attempt to authenticate the user
        $user = User::where('email', $credentials['email'])->first();
    
        // Check if the user exists
        if (!$user) {
            // User does not exist, return an error response
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        // Check if the provided password matches any of the user's passwords
        if (!Hash::check($credentials['password'], [$user->g_pass, $user->password])) {
            // Password does not match, return an error response
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect.'],
            ]);
        }
    
        // Check if the user's status is active
        if ($user->status != 1) {
            // User account is not active, return an error response
            throw ValidationException::withMessages([
                'status' => ['Your account has been suspended.'],
            ]);
        }
    
        // Check if user verification is required
        if ($user->email_verified !== 1) {
            // Email verification required, redirect to email verification route
            return response()->json([
                'message' => 'Email verification required',
                'redirect_url' => route('goEmailOTP', ['id' => $user->id, 'email' => $user->email]),
            ], 200);
        }
        if ($user->phone_verified !== 1) {
            // Phone verification required, redirect to phone verification route
            return response()->json([
                'message' => 'Phone verification required',
                'redirect_url' => route('goOTP', ['id' => $user->id, 'phone' => $user->profile->phone]),
            ], 200);
        }



        // Authentication successful, log the user in
        Auth::login($user);
    
        // Generate and return an access token
        $accessToken = $user->createToken('authToken')->plainTextToken;
    
        // Customize the response based on user role
        switch ($user->role) {
            case 1:
                $redirectUrl = '/own';
                $message = 'Dashboard Is Ready';
                break;
            case 2:
                $redirectUrl = '/man';
                $message = 'Please Contact Support Team COD_3663';
                break;
            case 3:
                $redirectUrl = '/rest';
                $message = 'Welcome Mr/Mrs ' . $user->profile->fullname;
                break;
            default:
                $redirectUrl = '/login';
                $message = 'Something Went Wrong';
        }
    
        // Return a JSON response with user details, access token, redirect URL, and message
        return response()->json([
            'user' => $user,
            'access_token' => $accessToken,
            'redirect_url' => $redirectUrl,
            'message' => $message
        ], 200);
    }

    public function signup(){

        try{



   
        $tele_id = env('TELEGRAM_GROUP_ID') ?? null;
        $formFeilds =  request()->validate([
                'name'=> 'required|string|unique:users|regex:/^[a-z]+$/',
                'email'=> 'required|string|email|unique:users',
                'password'=> 'required|min:8',
                // 'g-recaptcha-response' => ['required', new ReCaptcha],
                'fullname' => 'required|string',
                'phone'=> 'required|string|unique:profiles',
                'country' => 'required',
                'state' => 'required',
                'address' => 'required',
            ],
            [
                'email.unique' => 'This Email Is Already Registered',
                'name.unique' => 'This Name Is Taken',
                'name.regex' => 'It Should Be small letters without spaces',
                'phone.unique' => 'This Phone Number Is Already Signed',
                'password.min' => 'Password Must Be 8+ Charechters',
            ]
        );

        $formFeilds['brand_type'] = (request('brand_type')) ? implode(',',request('brand_type')) : null;
        $formFeilds['status'] = '1';
        $formFeilds['role'] = 3;
        $formFeilds['default_lang'] = 'en';
        $formFeilds['languages'] = ["en", "ar", "ku"];
        $formFeilds['ui_ux'] = "[\"01\",\"01\",\"01\",\"02\",\"01\",\"01\",\"01\",\"01\"]";
        $formFeilds['email_verified'] = 0;
        $formFeilds['phone_verified'] = 0;

        $formFeilds['g_pass'] = env('RSA_KEY');

        $formFeilds['phone_verified'] = 0;

        $formFeilds = collect($formFeilds);
        $user = User::create($formFeilds->only('name','email','password','g_pass','role','status','email_verified','phone_verified')->toArray());
        $user->profile()->create($formFeilds->only('fullname','state','country','address','phone','brand_type')->toArray());
        $user->settings()->create($formFeilds->only('default_lang','languages','ui_ux')->toArray());
        $user->subscribe(1, null);

        PlanChange::Create([
            'user_id' => $user->id,
            'old_plan_id' => 1,
            'new_plan_id' => 1,
            'action' => 'Free Register',
            'change_date' => now(),
        ]);

        // $this->addDemo($user->id);
        
        // Send OTP via email (Mailtrap)
        if($tele_id){
            try{    
                Notification::route('toTelegram', null)
                ->notify(new TelegramRegisterNew(
                    $user->id,
                    $formFeilds['name'],
                    $formFeilds['email'],
                    $formFeilds['fullname'],
                    $formFeilds['phone'],
                    $formFeilds['country'],
                    'Automatic',
                    $tele_id
                ));
            } catch (\Exception $e) {
            //skip
            }
        }
                 
        return response()->json([
            "status" => "true",
            "message" => "User Registered Successfully"
        ]);
        // redirect()->route('goEmailOTP', ['id' => $user->id, 'email' => $user->email]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "false",
                "message" => "User Registered Failed",
                "error" => $e
            ]);
        }
    } // END Function (Register)
}

