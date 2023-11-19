<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpController;
use App\Http\Controllers\ManController;
use App\Http\Controllers\OwnController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\BusinessController;
use App\Http\Middleware\LocalizationMiddleware;
use App\Http\Controllers\Gateaway\PlanController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Middleware\LocalizationMainMiddleware;
use App\Http\Controllers\Gateaway\CallBackController;
use App\Http\Controllers\Gateaway\TransactionController;
use App\Http\Controllers\Gateaway\SubscriptionController;
// use App\Http\Livewire\User\Components\Header01Livewire;
/*
|--------------------------------------------------------------------------
| Language Switcher / Dynamic Language Switcher
|--------------------------------------------------------------------------
*/
Route::post('/set-locale', [LocalizationMiddleware::class, 'setLocale'])->name('setLocale');
Route::post('/set-locale-start-up', [LocalizationMiddleware::class, 'setLocaleStartUp'])->name('setLocaleStartUp');

Route::controller(CallBackController::class)->group(function(){
    Route::post('/areeba/callback','areebaCallBack')->name('areeba.callback');
    Route::get('/zaincash/callback','zainCashCallBack');
});
/*
|--------------------------------------------------------------------------
| Main Pages for Guests
|--------------------------------------------------------------------------
*/
Route::middleware([LocalizationMainMiddleware::class])->group(function () {
/*
|--------------------------------------------------------------------------
| Auth Route
|--------------------------------------------------------------------------
*/
    Route::get('/login', [AuthController::class,'index'])->name('login');
    Route::post('/login', [AuthController::class,'login'])->name('logging');
    Route::get('/register',[AuthController::class,'register'])->name('register');
    Route::post('/register',[AuthController::class,'signup'])->name('signup');
    // Email Verification
    Route::get('/email-verify-otp/{id}/{email}', [AuthController::class,'goEmailOTP'])->name('goEmailOTP');
    Route::get('/update-email-otp/{id}', [AuthController::class,'goReEmailOTP'])->name('goReEmailOTP');
    Route::post('/update-email-otp-ser/{id}', [AuthController::class,'updateReEmailOTP'])->name('updateReEmailOTP');
    Route::get('/resend-verify-otp/{id}/{email}', [AuthController::class,'resendEmailOTP'])->name('resendEmailOTP');
    Route::post('/email-verify-otp', [AuthController::class,'verifyEmailOTP'])->name('verifyEmailOTP');
    // Phone Verification
    Route::get('/verify-otp/{id}/{phone}', [AuthController::class,'goOTP'])->name('goOTP');
    Route::get('/phone-resend-verify-otp/{id}/{phone}', [AuthController::class,'resendPhoneOTP'])->name('resendPhoneOTP');
    Route::post('/verify-otp', [AuthController::class,'verifyOTP'])->name('verifyOTP');

    Route::get('/logout', [AuthController::class,'logout'])->name('logout');
/*
|--------------------------------------------------------------------------
| Main Page Route
|--------------------------------------------------------------------------
*/
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
/*
|--------------------------------------------------------------------------
| Payment Route
|--------------------------------------------------------------------------
*/
    Route::controller(SubscriptionController::class)->group(function(){
        Route::get('/user-expire','userExpire');
        Route::get('/admin-expire','adminExpire');
        Route::post('/subscribe','subscribe');
    });

    Route::controller(PlanController::class)->group(function(){
        Route::get('/plans/{id}','show');
    });

    Route::controller(TransactionController::class)->group(function(){
        Route::get('/payment/cancel','cancel');
        Route::get('/payment/error','pageError');
        Route::get('/payment/success','success');
    });



/*
|--------------------------------------------------------------------------
| Forget Password Route
|--------------------------------------------------------------------------
*/
    //Email
    Route::get('/password/forget',[ForgotPasswordController::class, 'showLinkRequestEmail'])->name('passwordRequestEmail');
    Route::post('/password/forget', [ForgotPasswordController::class, 'checkResetLinkEmail'])->name('checkResetLinkEmail');
    Route::get('/password/e/forget/{email}', [ForgotPasswordController::class, 'showLinkRequestEmailOtp'])->name('showLinkRequestEmailOtp');
    Route::post('/password/e/s/forget/{email}', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('sendResetLinkEmail');
    Route::post('/password/z/forget', [ForgotPasswordController::class, 'verifyResetLinkEmail'])->name('verifyResetLinkEmail');
    // Route::get('/password/c/forget', [ForgotPasswordController::class, 'checkResetLinkEmail'])->name('checkResetLinkEmail');
    //Phone
    Route::get('/password/p/forget/{id}',[ForgotPasswordController::class, 'showLinkRequestPhone'])->name('passwordRequestPhone');
    Route::post('/password/p/forget/{id}', [ForgotPasswordController::class, 'checkResetLinkPhone'])->name('checkResetLinkPhone');
    Route::get('/password/c/p/forget/{id}', [ForgotPasswordController::class, 'showLinkRequestPhoneOtp'])->name('showLinkRequestPhoneOtp');
    Route::post('/password/c/p/forget/{id}', [ForgotPasswordController::class, 'sendResetLinkPhone'])->name('sendResetLinkPhone');
    Route::post('/password/z/p/forget/', [ForgotPasswordController::class, 'verifyResetLinkPhone'])->name('verifyResetLinkPhone');
    //Reset Password
    Route::get('/password/forget/ver/{id}', [ForgotPasswordController::class, 'passwordNewPassword'])->name('passwordNewPassword');
    Route::post('/password/forget/ver', [ForgotPasswordController::class, 'passwordSendPassword'])->name('passwordSendPassword');
});

/*
|--------------------------------------------------------------------------
| checkStatus: Chek The Status, LocalizationMiddleware: Check The Custom Language
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| MET ROUTE SUPER ADMIN
|--------------------------------------------------------------------------
*/  
Route::prefix('/own')->middleware(['LocalizationMainMiddleware', 'superadmin'])->group(function () {
    Route::get('/', [OwnController::class, 'dashboardOwn'])->name('dashboardOwn');
    Route::get('/useractivity', [OwnController::class, 'userActivity'])->name('userActivity');
    Route::get('/userinformation', [OwnController::class, 'userInformation'])->name('userInformation');
    Route::get('/usersdata', [OwnController::class, 'userData'])->name('userData');
    Route::get('/plan/userplanview', [OwnController::class, 'userPlanView'])->name('userPlanView');
    Route::get('/plan/guestplanview', [OwnController::class, 'guestPlanView'])->name('guestPlanView');
    Route::get('/plan/plansetting', [OwnController::class, 'planSetting'])->name('planSetting');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTE ADMIN
|--------------------------------------------------------------------------
*/  
Route::prefix('/man')->middleware(['checkStatus', 'LocalizationMiddleware', 'admin'])->group(function () {
    Route::get('/', [ManController::class, 'dashboard'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| REST ROUTE RESTURANT OWNER
|--------------------------------------------------------------------------
*/
Route::prefix('/rest')->middleware(['checkStatus', 'LocalizationMiddleware', 'rest'])->group(function () {
    Route::get('/', [RestController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [RestController::class, 'profile'])->name('profile');
    Route::get('/mainmenu', [RestController::class, 'mainmenu'])->name('mainmenu');
    Route::get('/category', [RestController::class, 'category'])->name('category');
    Route::get('/food', [RestController::class, 'food'])->name('food');
    Route::get('/offer', [RestController::class, 'offer'])->name('offer');
    Route::get('/setting/language', [RestController::class, 'languageSetting'])->name('languageSetting');
    Route::get('/setting/name', [RestController::class, 'nameSetting'])->name('nameSetting');
    Route::get('/setting/menu', [RestController::class, 'menuSetting'])->name('menuSetting');
    Route::get('/setting/startup', [RestController::class, 'startSetting'])->name('startSetting');
    Route::get('/plan', [RestController::class, 'plan'])->name('plan');
    Route::get('/design/uiux', [RestController::class, 'designUiUx'])->name('designUiUx');
    Route::get('/design/customize', [RestController::class, 'designCustomize'])->name('designCustomize');
    Route::get('/design/qr', [RestController::class, 'designQr'])->name('designQr');
    Route::get('/support/tutorial', [RestController::class, 'supportVideo'])->name('supportVideo');
    Route::get('/support/document', [RestController::class, 'supportDocument'])->name('supportDocument');
    Route::get('/support/contactus', [RestController::class, 'supportContactUs'])->name('supportContactUs');
    Route::get('/support/menufix', [RestController::class, 'supportMenuFix'])->name('supportMenuFix');
    Route::get('/support/error', [RestController::class, 'supportError'])->name('supportError');
});
 /*
|--------------------------------------------------------------------------
| EMP ROUTE EMPLOYEE
|--------------------------------------------------------------------------
*/
// Route::prefix('/emp')->middleware(['checkStatus', 'LocalizationMiddleware', 'emp'])->group(function () {
//     Route::get('/', [EmpController::class, 'dashboard'])->name('dashboard');
// });

/*
|--------------------------------------------------------------------------
| User Pages with User ID Prefix
|--------------------------------------------------------------------------
*/
Route::prefix('/{business_name}')->middleware(['LocalizationMiddleware','TrackerVisit'])->group(function () {
    Route::get('/', [BusinessController::class, 'category'])->name('business.home');
    Route::get('/start', [BusinessController::class, 'startUp'])->name('business.zzz');

    Route::middleware('track-clicks:business_name')->group(function () {
        Route::get('/cat/{food}', [BusinessController::class, 'food'])->name('business.food');
        Route::get('/cat/{food}/{detail}', [BusinessController::class, 'foodDetail'])->name('business.food_detail');
    });
    
    Route::get('/offer/{detail}', [BusinessController::class, 'offerDetail'])->name('business.offer_detail');
    // PWA DYNAMIC
    Route::get('/manifest', [BusinessController::class, 'generateManifest'])->name('generateManifest');
});
/*
|--------------------------------------------------------------------------
| Third Part Route
|--------------------------------------------------------------------------
*/
Route::post('/contactus-whatsapp', [MessageController::class, 'contactUsApp'])->name('contactUsApp');
