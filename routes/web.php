<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix("auth")->group(function () {
    Route::get('registration', [\App\Http\Controllers\AuthController::class, 'registration'])->name('registration');
})->name('auth.');