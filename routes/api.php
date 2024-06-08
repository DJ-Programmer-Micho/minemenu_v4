<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Gateaway\CallBackController;
use App\Http\Controllers\Api\V1\BusinessApiController;
use App\Http\Controllers\Api\V1\ContactUsViaApp;
use App\Http\Controllers\Api\V1\MainMenuApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/areeba/callback', [CallBackController::class, 'areebaCallBack'])
    ->middleware('throttle:60,1') 
    ->name('areeba.callback');
    
Route::prefix('/v1')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Auth Route
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/sanctum/token', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
     
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            if (! $user || ! Hash::check($request->password, $user->g_pass)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
            }
        }
     

        // $token = $user->createToken($request->device_name, ['*'], now()->addMonth())->plainTextToken;
        $token = $user->createToken($request->device_name, ['*'], now()->addMinutes(2))->plainTextToken;

        // $expires_at = now()->addDays(30);
        $expires_at = now()->addMinutes(2);


        $tokenParts = explode('|', $token);
        $token_id = $tokenParts[0];
        $token_value = $tokenParts[1];
    
        return response()->json([
            'userData' => $user,
            'tokenId' => $token_id,
            'token' => $token_value,
            'expiresAt' => $expires_at->format('Y-m-d H:i:s')
        ]);
        // return $user->createToken($request->device_name)->plainTextToken;
    });
    
    Route::middleware('auth:sanctum')->get('/user/revoke', function (Request $request) {
        $user = $request->user();
        $user->tokens()->delete();
        return "Tokens Are Deleted";
    });
    


    Route::post('/login', [AuthApiController::class, 'login'])->name('api.login.submit'); // POST request to submit login credentials
    Route::post('/register', [AuthApiController::class, 'signup'])->name('api.register.submit'); // GET just testing
    Route::post('/login', [AuthApiController::class, 'login'])->name('api.login.submit'); // POST request to submit login credentials
    Route::post('/contactusapp', [contactUsViaApp::class, 'contactUsViaApp']);

});





// 'auth:sanctum'
Route::prefix('/v1/{business_name}')->middleware(['LocalizationApiMiddleware'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Data Route
    |--------------------------------------------------------------------------
    */
    Route::get('/setting', [BusinessApiController::class, 'setting'])->name('api.business.setting');
    Route::get('/subscription', [BusinessApiController::class, 'subscription'])->name('api.business.subscription');
    Route::get('/validation', [BusinessApiController::class, 'appValidation'])->name('api.business.appValidation');

    Route::get('/', [BusinessApiController::class, 'menu'])->name('api.business.menu');
    Route::get('/cat',[BusinessApiController::class, 'category'])->name('api.business.cat');
    Route::get('/food',[BusinessApiController::class, 'food'])->name('api.business.food');
    Route::get('/foodDetail',[BusinessApiController::class, 'foodDetail'])->name('api.business.foodDetail');

    Route::get('/offer',[BusinessApiController::class, 'offer'])->name('api.business.offer');
    Route::get('/offerdetail',[BusinessApiController::class, 'offerDetail'])->name('api.business.offerDetail');

    Route::post('/submitRestRating', [BusinessApiController::class, 'submitRestRating']);
    Route::post('/registerCustomerAndRateRest', [BusinessApiController::class, 'registerCustomerAndRateRest']);

    Route::post('/submitFoodRating', [BusinessApiController::class, 'submitFoodRating']);
    Route::post('/registerCustomerAndRateFood', [BusinessApiController::class, 'registerCustomerAndRateFood']);
});

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('api.login'); // GET request to show login form
// Route::prefix('/api/v1')->middleware(['api'])->group(function () {
//     Route::get('/mainmenu', [MainMenuApiController::class, 'index']);
//     Route::post('/mainmenu', [MainMenuApiController::class, 'store']);
//     Route::get('/mainmenu/{id}', [MainMenuApiController::class, 'show']);
//     Route::put('/mainmenu/{id}', [MainMenuApiController::class, 'update']);
//     Route::delete('/mainmenu/{id}', [MainMenuApiController::class, 'destroy']);
// });
