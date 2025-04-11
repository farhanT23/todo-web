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

    Route::get('login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

    Route::get('new-password', [\App\Http\Controllers\AuthController::class, 'newPassword'])->name('new-password');
    Route::get('forget-password', [\App\Http\Controllers\AuthController::class, 'forgetPassword'])->name('forget-password');
});




Route::group(['middleware' => ['auth']], function () {
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


    Route::prefix("dashboard")->group(function () {
        Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    });

    Route::prefix("tasks")->group(function () {
        Route::get('/', [\App\Http\Controllers\TaskController::class, 'index'])->name('tasks');
        Route::get('/create', [\App\Http\Controllers\TaskController::class, 'create'])->name('task-create');
        Route::post('/store', [\App\Http\Controllers\TaskController::class, 'store'])->name('task-store');
        Route::get('/edit/{id}', [\App\Http\Controllers\TaskController::class, 'edit'])->name('task-edit');
        Route::post('/update/{id}', [\App\Http\Controllers\TaskController::class, 'update'])->name('task-update');
        Route::get('/delete/{id}', [\App\Http\Controllers\TaskController::class, 'delete'])->name('task-delete');
    });

});