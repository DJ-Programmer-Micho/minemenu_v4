<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpController;
use App\Http\Controllers\ManController;
use App\Http\Controllers\OwnController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestController;
use App\Http\Middleware\LocalizationMiddleware;

/*
|--------------------------------------------------------------------------
| Language Switcher / Dynamic Language Switcher
|--------------------------------------------------------------------------
*/
Route::post('/set-locale', [LocalizationMiddleware::class, 'setLocale'])->name('setLocale');


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
Route::prefix('/{business_name}')->middleware(['LocalizationMiddleware'])->group(function () {
    Route::get('/', [HomeController::class, 'test'])->name('user.home');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts', [PostController::class, 'show'])->name('posts.show');
    Route::get('/profile', [UserPageController::class, 'profile'])->name('user.profile');
    Route::get('/settings', [UserPageController::class, 'settings'])->name('user.settings');
});
