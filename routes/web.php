<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [LandingController::class, 'showGreeting'])->name('landing');;


Route::prefix("auth")->group(function () {

    Route::get('registration', [\App\Http\Controllers\AuthController::class, 'registration'])->name('registration');
    Route::post('registration', [\App\Http\Controllers\AuthController::class, 'registrationSave'])->name('registration-save');

    Route::get('verify-email/{otp}', [\App\Http\Controllers\AuthController::class, 'verifyEmail'])->name('verify');

    Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::get('new-password', [\App\Http\Controllers\AuthController::class, 'newPassword'])->name('new-password');
    Route::get('forget-password', [\App\Http\Controllers\AuthController::class, 'forgetPassword'])->name('forget-password');
});

Route::prefix("dashboard")->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});