<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [LandingController::class, 'showGreeting'])->name('landing');;


Route::prefix("auth")->group(function () {

    Route::get('registration', [AuthController::class, 'registration'])->name('registration');


    Route::post('registration', [AuthController::class, 'registrationSave'])->name('registration-save');

    Route::get('verify-email/{otp}', [AuthController::class, 'verifyEmail'])->name('verify');

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    //forget password
    Route::get('forget-password', [AuthController::class, 'forgetPasswordForm'])->name('forget-password');
    Route::post('/forget-password', [AuthController::class, 'sendResetLink']);

    //reset password
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

});




Route::group(['middleware' => ['auth']], function () {
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


    Route::prefix("dashboard")->group(function () {
        Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    });

    Route::prefix("tasks")->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks');
        Route::post('/create', [TaskController::class, 'create'])->name('task-create');
        Route::get('/edit/{id}', [TaskController::class, 'edit'])->name('task-edit');
        Route::post('/update/{id}', [TaskController::class, 'update'])->name('task-update');
        Route::get('/delete/{id}', [TaskController::class, 'delete'])->name('task-delete');
    });

});
