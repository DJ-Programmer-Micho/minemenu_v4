<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\LocalizationMiddleware;

/*
|--------------------------------------------------------------------------
| Language Switcher / Dynamic Language Switcher
|--------------------------------------------------------------------------
*/
Route::post('/set-locale', [LocalizationMiddleware::class, 'setLocale'])->name('setLocale');

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Main Pages for Guests
|--------------------------------------------------------------------------
*/
Route::middleware([LocalizationMiddleware::class])->group(function () {
/*
|--------------------------------------------------------------------------
| Auth Route
|--------------------------------------------------------------------------
*/
    Route::get('/login', [AuthController::class,'index'])->name('login');
    Route::post('/login', [AuthController::class,'login'])->name('logging');
    Route::get('/register',[AuthController::class,'register'])->name('register');
    Route::post('/register',[AuthController::class,'signUp']);
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
| Security Check For All Users Types
|--------------------------------------------------------------------------
*/
Route::middleware('checkStatus')->group(function () {
 /*
|--------------------------------------------------------------------------
| MET ROUTE SUPER ADMIN
|--------------------------------------------------------------------------
*/  
    Route::get('/own', function(){
        return view('dashboard.own.layouts.layout');
    })->name('superadmin')->middleware('superadmin');
 /*
|--------------------------------------------------------------------------
| ADMIN ROUTE ADMIN
|--------------------------------------------------------------------------
*/  
    Route::get('/man', function(){
        return view('dashboard.own.layouts.layout');
    })->name('admin')->middleware('admin');
 /*
|--------------------------------------------------------------------------
| REST ROUTE RESTURANT OWNER
|--------------------------------------------------------------------------
*/
    Route::get('/rest', function(){
        return view('dashboard.rest.pages.menu.index');
    })->name('rest')->middleware('rest');
 /*
|--------------------------------------------------------------------------
| EMP ROUTE EMPLOYEE
|--------------------------------------------------------------------------
*/
    Route::get('/emp', function(){
        return view('dashboard.emp.layouts.layout');
    })->name('emp')->middleware('emp');
});


/*
|--------------------------------------------------------------------------
| User Pages with User ID Prefix
|--------------------------------------------------------------------------
*/
Route::prefix('/{business_name}')->middleware([LocalizationMiddleware::class])->group(function () {
    Route::get('/', [UserPageController::class, 'home'])->name('user.home');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts', [PostController::class, 'show'])->name('posts.show');
    Route::get('/profile', [UserPageController::class, 'profile'])->name('user.profile');
    Route::get('/settings', [UserPageController::class, 'settings'])->name('user.settings');
});
