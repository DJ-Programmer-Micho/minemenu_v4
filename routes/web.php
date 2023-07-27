<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// User Credintials/Register
Route::get('/login', [AuthController::class,'index'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('logging');
Route::get('/register',[AuthController::class,'register'])->name('register');
Route::post('/register',[AuthController::class,'signUp']);
Route::get('/logout', [AuthController::class,'logout'])->name('logout');


// resources/views/dashboard/rest/layouts/layout.blade.php


Route::middleware('checkStatus')->group(function () {
    
    // MET ROUTE SUPER ADMIN
    Route::get('/own', function(){
        return view('dashboard.own.layouts.layout');
    })->name('superadmin')->middleware('superadmin');
    
    // ADMIN ROUTE ADMIN
    Route::get('/man', function(){
        return view('dashboard.own.layouts.layout');
    })->name('admin')->middleware('admin');

    // REST ROUTE RESTURANT OWNER
    Route::get('/rest', function(){
        return view('dashboard.rest.pages.menu.index');
    })->name('rest')->middleware('rest');

    // EMP ROUTE EMPLOYEE
    Route::get('/emp', function(){
        return view('dashboard.emp.layouts.layout');
    })->name('emp')->middleware('emp');
});
