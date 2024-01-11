<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\User;
use App\Models\Mainmenu;
use App\Rules\ReCaptcha;
use App\Otp\SinchService;
use App\Models\Categories;
use App\Models\PlanChange;
use Illuminate\Http\Request;
use App\Models\Food_Translator;
use App\Mail\EmailVerificationMail;
use App\Models\Mainmenu_Translator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Categories_Translator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Owner\TelegramRegisterNew;

class AuthController extends Controller
{
    public function index(){
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
        $flag = false;
        if ($user) {
            if (password_verify($credentials['password'], $user->g_pass )) {
                $flag = true;
                Auth::login($user);
                $this->verifyUserCheker($user, $credentials);
        } else {
            if (password_verify($credentials['password'], $user->password )) {
                $flag = true;
                Auth::login($user);
                $this->verifyUserCheker($user, $credentials);
            }
        }
    } else {
        $flag = false;
        return redirect('/login')->with('alert', [
            'type' => 'error',
            'message' => __('Invalid credentials or user is inactive.'),
        ]);
    }
        
        //Check Auth Role
        if ($user && $user->status == 1 && $flag == true) {
        // if ($user && $user->status == 1 && Auth::attempt($credentials)) {
            $user_role = Auth::user()->role;
    // dd($user_role);
            switch ($user_role) {
                case 1:
                    return redirect('/own')->with('alert', [
                        'type' => 'success',
                        'message' => __('Dashboard Is Ready'),
                    ]);
                    break;
                case 2:
                    return redirect('/man')->with('alert', [
                        'type' => 'warning',
                        'message' => __('Please Contact Support Team COD_3663'),
                    ]);
                    break;
                case 3:
                    return redirect('/rest')->with('alert', [
                        'type' => 'success',
                        'message' => __('Welcome Mr/Mrs') . $user->profile->fullname,
                    ]);
                    break;
                // case 4:
                //     return redirect('/emp')->with('alert', [
                //         'type' => 'warning',
                //         'message' => __('Please Contact Support Team COD_3663'),
                //     ]);
                //     break;
                default:
                    Auth::logout();
                    return redirect('/login')->with('alert', [
                        'type' => 'error',
                        'message' => __('Something Went Wrong'),
                    ]);
            }
        } else {
            return redirect('/login')->with('alert', [
                'type' => 'error',
                'message' => __('Account Has Been Suspended.'),
            ]);
        }
    } // END Function (Login Fucntion)


    // Private Function Checker (Email and Phone)
    private function verifyUserCheker($user, $credentials) {
        if ($user && $user->status == 1 && Auth::attempt($credentials)) {
            if ($user->email_verified === null || $user->email_verified === 0) {
                return redirect()->route('goEmailOTP', ['id' => $user->id, 'email' => $user->email]);
            } elseif ($user->phone_verified === null || $user->phone_verified === 0) {
                return redirect()->route('goOTP', ['id' => $user->id, 'phone' => $user->profile->phone]);
            }
        }
    }

    public function register(){
        return view('auth.register');
    } // END Function (Register)

    public function signup(){
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

        $this->addDemo($user->id);
        
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
                 
        return redirect()->route('goEmailOTP', ['id' => $user->id, 'email' => $user->email]);
    } // END Function (Register)

    public function goEmailOTP($uid, $email){
        return view('auth.emailOtp',['id' => $uid, 'email' => $email]);
    } // END Function (Register)

    public function goReEmailOTP($uid){
        
        return view('auth.emailReOtp',['id' => $uid]);
    } // END Function (Register)

    public function updateReEmailOTP($uid, Request $request){
    // dd($request->all());
    $user = User::find($uid);
    if (!$user) {
        return abort(404); // Or handle the case where the user is not found
    }
        $new_email = $request->email;
        if(User::where('email', $new_email)->exists()) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => __('Check Your Email Spelling, Or Email Has been Alreary Registerd'),
            ]);
        } else {
            $user->email = $new_email;
            $user->save();
            
            return redirect()->route('goEmailOTP', ['id' => $user->id, 'email' => $new_email])->with('alert', [
                'type' => 'success',
                'message' => __('Email Updated!'),
            ]);
        }
    } // END Function (update email)
    
    public function resendEmailOTP($id, $email){
        $user = User::where('email', $email)->first();
        if ($user) {
            $otpCodeEmail = rand(100000, 999999);
            // Update the user's email OTP code
            // $user->email_otp_code = $otpCodeEmail;
            $user->updateOrCreate(
                ['id' => $user->id], // Use the primary key column for identification
                ['email_otp_code' => $user->email_otp_code ?: $otpCodeEmail]
            );
            // $user->save();
            // Send OTP via email (Mailtrap)
            Mail::to($user->email)->send(new EmailVerificationMail($otpCodeEmail));
            session()->flash('alert', [
                'type' => 'success',
                'message' => __('PIN CODE SENT!, Please Check Your Email'),
            ]);
            return redirect()->route('goEmailOTP', ['id' => $id, 'email' => $user->email]);
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }

//////////////////////////////
// START OF WITH PHONE NUMBER AUTH OTP
//////////////////////////////
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
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => __('Wrong Code!'),
            ]);
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
                return redirect()->route('goOTP', ['id'=> $id, 'phone' => $phone])->with('alert', [
                    'type' => 'success',
                    'message' => __('PIN SENT!, Please check your SMS'),
                ]);
            } else {
                $clean_phone_number = preg_replace('/[^0-9+]/', '', $user->profile->phone);
                if (strpos($clean_phone_number, '+') === 0) {
                    $final_clean_phone_number = '00' . substr($clean_phone_number, 1);
                } else {
                    $final_clean_phone_number = $clean_phone_number;
                }
                $s_response = SinchService::sendOTP($final_clean_phone_number);
                if($response->successful()) {
                    return redirect()->route('goOTP', ['id'=> $id, 'phone' => $phone])->with('alert', [
                        'type' => 'success',
                        'message' => __('PIN SENT!, Please check your SMS'),
                    ]);
                } else {
                    // return $s_response;
                    return redirect()->back()->with('alert', [
                        'type' => 'error',
                        'message' => __('Something Went Wrong!, Please check your phone number or the Phone Number is Already Registered'),
                    ]);
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
            return redirect('/rest')
            ->with('alert', [
                'type' => 'success',
                'message' => __('Registration completed.'),
            ]);
        } else {
            // dd('error');
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => __('Wrong Code!'),
            ]);
        }
    }
//////////////////////////////
// END OF WITH PHONE NUMBER AUTH OTP
//////////////////////////////

/////////////////////////////////
// START OF WITHOUT PHONE NUMBER AUTH OTP
/////////////////////////////////

// public function verifyEmailOTP(Request $request)
// {
//     // Verify email OTP code...
//     $enteredEmailOTP = $request->input('entered_email_otp_code');
//     $user = User::where('email', $request->input('email'))->first();

//     if ($user && $enteredEmailOTP == $user->email_otp_code) {
//         $user->email_verified = 1;
//         $user->phone_verified = 1;
//         $user->save();
//         auth()->login($user);
//         return redirect('/rest')
//         ->with('alert', [
//             'type' => 'success',
//             'message' => __('Registration completed.'),
//         ]);
//     } else {
//         // dd('error');
//         return redirect()->back()->with('alert', [
//             'type' => 'error',
//             'message' => __('Wrong Code!'),
//         ]);
//     }
// }
/////////////////////////////////
// END OF WITHOUT PHONE NUMBER AUTH OTP
/////////////////////////////////

    public function logout(){
        auth()->logout();
        return back();
    } // END Function (Logout)


    private function addDemo($rest_id){
        // for($i = 0; $i <= 2; $i){
           // Create two main menus for the user
           $menus = [];
           $categories = [];
           $translations = [
               ['en', 'Food', 'ar', 'الأطعمة'],
               ['en', 'Drinks', 'ar', 'المشروبات']
           ];

           $categoriesData = [
               ['en', 'Category1', 'ar', 'التصنيف1','mine-setting/default-demo/minemenu_category_1.jpeg','mine-setting/default-demo/minemenu_category_cov_1.jpeg'],
               ['en', 'Category2', 'ar', 'التصنيف2','mine-setting/default-demo/minemenu_category_2.jpeg','mine-setting/default-demo/minemenu_category_cov_2.jpeg'],
               ['en', 'Category3', 'ar', 'التصنيف3','mine-setting/default-demo/minemenu_category_3.jpeg','mine-setting/default-demo/minemenu_category_cov_3.jpeg'],
               ['en', 'Category4', 'ar', 'التصنيف4','mine-setting/default-demo/minemenu_category_4.jpeg','mine-setting/default-demo/minemenu_category_cov_4.jpeg']
           ];
           
           $foodsData = [
               ['en', 'Food1', 'ar', 'طعام', 33000, null, 'mine-setting/default-demo/minemenu_food_1.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food2', 'ar', 'طعام', 40000, 55000, 'mine-setting/default-demo/minemenu_food_2.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food3', 'ar', 'طعام', 25000, null, 'mine-setting/default-demo/minemenu_food_3.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food4', 'ar', 'طعام', 35000, null, 'mine-setting/default-demo/minemenu_food_4.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food5', 'ar', 'طعام', 17000, null, 'mine-setting/default-demo/minemenu_food_5.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food6', 'ar', 'طعام', 18000, null, 'mine-setting/default-demo/minemenu_food_6.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food7', 'ar', 'طعام', 17000, null, 'mine-setting/default-demo/minemenu_food_7.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food8', 'ar', 'طعام', 15500, 17000, 'mine-setting/default-demo/minemenu_food_8.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food9', 'ar', 'طعام', 5500, null, 'mine-setting/default-demo/minemenu_food_9.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food10', 'ar', 'طعام', 4000, 5500, 'mine-setting/default-demo/minemenu_food_10.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food11', 'ar', 'طعام', 1750, null, 'mine-setting/default-demo/minemenu_food_11.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food12', 'ar', 'طعام', 1750, null, 'mine-setting/default-demo/minemenu_food_12.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food13', 'ar', 'طعام', 6000, 7500, 'mine-setting/default-demo/minemenu_food_13.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food14', 'ar', 'طعام', 7500, null, 'mine-setting/default-demo/minemenu_food_14.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food15', 'ar', 'طعام', 4500, null, 'mine-setting/default-demo/minemenu_food_15.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
               ['en', 'Food16', 'ar', 'طعام', 6500, null, 'mine-setting/default-demo/minemenu_food_16.jpeg', 'This section provides a description of the food that needs to be added. You can include as much information as you prefer, but it is recommended to keep it within 150 characters.','يقدم هذا القسم وصفًا للأطعمة الاختيارية المراد إضافتها. يمكنك تضمين أي قدر تفضله من المعلومات، ولكن يوصى بالاحتفاظ بها ضمن 150 حرفًا.'],
           ];
           
           for ($i = 0; $i < 2; $i++) {
               $menu = Mainmenu::create([
                   'user_id' => $rest_id,
                   'priority' => 1,
                   'status' => 1,
               ]);
           
               $menuTranslator = Mainmenu_Translator::create([
                   'menu_id' => $menu->id,
                   'name' => $translations[$i][1],
                   'lang' => $translations[$i][0],
               ]);
           
               $menuTranslatorAr = Mainmenu_Translator::create([
                   'menu_id' => $menu->id,
                   'name' => $translations[$i][3],
                   'lang' => $translations[$i][2],
               ]);
           
               $menus[] = $menu;
           
               for ($j = 0; $j < 2; $j++) {
                   $category = Categories::create([
                       'user_id' => $rest_id,
                       'menu_id' => $menu->id,
                       'priority' => 1,
                       'status' => 1,
                       'img' => $categoriesData[$i * 2 + $j][4],
                       'cover' => $categoriesData[$i * 2 + $j][5],
                   ]);
           
                   $categoryTranslator = Categories_Translator::create([
                       'cat_id' => $category->id,
                       'name' => $categoriesData[$i * 2 + $j][1],
                       'locale' => $categoriesData[$i * 2 + $j][0],
                   ]);
           
                   $categoryTranslatorAr = Categories_Translator::create([
                       'cat_id' => $category->id,
                       'name' => $categoriesData[$i * 2 + $j][3],
                       'locale' => $categoriesData[$i * 2 + $j][2],
                   ]);
           
                   $categories[] = $category;
           
                   // Create 3 foods for each category
                   for ($k = 0; $k < 4; $k++) {
                    $food = Food::create([
                        'user_id' => $rest_id,
                        'cat_id' => $category->id,
                        'priority' => 1,
                        'price' => $foodsData[($i * 8) + ($j * 4) + $k][4],
                        'old_price' => $foodsData[($i * 8) + ($j * 4) + $k][5],
                        'options' =>  null,
                        'sorm' => 0,
                        'status' => 1,
                        'special' => 0,
                        'img' => $foodsData[($i * 8) + ($j * 4) + $k][6],
                    ]);
                
                    $foodTranslator = Food_Translator::create([
                        'food_id' => $food->id,
                        'name' => $foodsData[($i * 8) + ($j * 4) + $k][1],
                        'description' => $foodsData[($i * 8) + ($j * 4) + $k][7],
                        'lang' => $foodsData[($i * 8) + ($j * 4) + $k][0],
                    ]);
                
                    $foodTranslatorAr = Food_Translator::create([
                        'food_id' => $food->id,
                        'name' => $foodsData[($i * 8) + ($j * 4) + $k][3],
                        'description' => $foodsData[($i * 8) + ($j * 4) + $k][8],
                        'lang' => $foodsData[($i * 8) + ($j * 4) + $k][2],
                    ]);
                }
               }
           }
    }
}

