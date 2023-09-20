<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpController;
use App\Http\Controllers\ManController;
use App\Http\Controllers\OwnController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\BusinessController;
use App\Http\Middleware\LocalizationMiddleware;
// use App\Http\Livewire\User\Components\Header01Livewire;
/*
|--------------------------------------------------------------------------
| Language Switcher / Dynamic Language Switcher
|--------------------------------------------------------------------------
*/
Route::post('/set-locale', [LocalizationMiddleware::class, 'setLocale'])->name('setLocale');
Route::post('/set-locale-start-up', [LocalizationMiddleware::class, 'setLocaleStartUp'])->name('setLocaleStartUp');


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
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');
/*
|--------------------------------------------------------------------------
| Main Page Route
|--------------------------------------------------------------------------
*/
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
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
Route::prefix('/own')->middleware(['checkStatus', 'LocalizationMiddleware', 'superadmin'])->group(function () {
    Route::get('/', [OwnController::class, 'dashboard'])->name('dashboard');
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
    Route::get('/mainmenu', [RestController::class, 'mainmenu'])->name('mainmenu');
    Route::get('/category', [RestController::class, 'category'])->name('category');
    Route::get('/food', [RestController::class, 'food'])->name('food');
    Route::get('/offer', [RestController::class, 'offer'])->name('offer');
    Route::get('/setting/language', [RestController::class, 'languageSetting'])->name('languageSetting');
    Route::get('/setting/name', [RestController::class, 'nameSetting'])->name('nameSetting');
    Route::get('/setting/menu', [RestController::class, 'menuSetting'])->name('menuSetting');
    Route::get('/setting/startup', [RestController::class, 'startSetting'])->name('startSetting');
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
Route::prefix('/emp')->middleware(['checkStatus', 'LocalizationMiddleware', 'emp'])->group(function () {
    Route::get('/', [EmpController::class, 'dashboard'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| User Pages with User ID Prefix
|--------------------------------------------------------------------------
*/
Route::prefix('/{business_name}')->middleware(['LocalizationMiddleware','TrackerVisit'])->group(function () {
    Route::get('/', [BusinessController::class, 'category'])->name('business.home');
    Route::get('/start', [BusinessController::class, 'startUp'])->name('business.zzz');
    Route::get('/cat/{food}', [BusinessController::class, 'food'])->name('business.food')->middleware('track-clicks:business_name');
    Route::get('/cat/{food}/{detail}', [BusinessController::class, 'foodDetail'])->name('business.food_detail')->middleware('track-clicks:business_name');
    Route::get('/offer/{detail}', [BusinessController::class, 'offerDetail'])->name('business.offer_detail');
    // PWA DYNAMIC
    Route::get('/manifest', [BusinessController::class, 'generateManifest'])->name('generateManifest');
});
