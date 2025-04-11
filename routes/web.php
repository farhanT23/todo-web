<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [LandingController::class, 'showGreeting'])->name('landing');;


Route::prefix("auth")->group(function () {
    Route::get('registration', [\App\Http\Controllers\AuthController::class, 'registration'])->name('registration');
    Route::get('login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::get('new-password', [\App\Http\Controllers\AuthController::class, 'newPassword'])->name('new-password');
    Route::get('forget-password', [\App\Http\Controllers\AuthController::class, 'forgetPassword'])->name('forget-password');
});

Route::prefix("dashboard")->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});


