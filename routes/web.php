<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix("auth")->group(function () {
    Route::get('registration', [\App\Http\Controllers\AuthController::class, 'registration'])->name('registration');
});


Route::prefix("dashboard")->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});