<?php

use App\Http\Controllers\Auth\AgentAuthController;
use App\Http\Controllers\Auth\StaffAuthController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Staff\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Staff portal (admissions, receptionist, coordinator, accounts, management)
|--------------------------------------------------------------------------
*/
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('login', [StaffAuthController::class, 'showEmailForm'])->name('login');
    Route::post('login', [StaffAuthController::class, 'sendCode'])->name('login.send');
    Route::get('login/verify', [StaffAuthController::class, 'showVerifyForm'])->name('login.verify');
    Route::post('login/verify', [StaffAuthController::class, 'verifyCode'])->name('login.verify.submit');
    Route::post('logout', [StaffAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:staff')->group(function () {
        Route::get('dashboard', function () {
            return view('staff.dashboard');
        })->name('dashboard');

        // Super Admin / Manager only - enforced inside the controller.
        Route::get('team', [TeamController::class, 'index'])->name('team.index');
        Route::get('team/create', [TeamController::class, 'create'])->name('team.create');
        Route::post('team', [TeamController::class, 'store'])->name('team.store');
    });
});

/*
|--------------------------------------------------------------------------
| Student portal
|--------------------------------------------------------------------------
*/
Route::prefix('student')->name('student.')->group(function () {
    Route::get('register', [StudentAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [StudentAuthController::class, 'register'])->name('register.submit');

    Route::get('login', [StudentAuthController::class, 'showEmailForm'])->name('login');
    Route::post('login', [StudentAuthController::class, 'sendCode'])->name('login.send');
    Route::get('login/verify', [StudentAuthController::class, 'showVerifyForm'])->name('login.verify');
    Route::post('login/verify', [StudentAuthController::class, 'verifyCode'])->name('login.verify.submit');
    Route::post('logout', [StudentAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:student')->group(function () {
        Route::get('dashboard', function () {
            return view('student.dashboard');
        })->name('dashboard');
    });
});

/*
|--------------------------------------------------------------------------
| Agent / education consultant portal
|--------------------------------------------------------------------------
*/
Route::prefix('agent')->name('agent.')->group(function () {
    Route::get('login', [AgentAuthController::class, 'showEmailForm'])->name('login');
    Route::post('login', [AgentAuthController::class, 'sendCode'])->name('login.send');
    Route::get('login/verify', [AgentAuthController::class, 'showVerifyForm'])->name('login.verify');
    Route::post('login/verify', [AgentAuthController::class, 'verifyCode'])->name('login.verify.submit');
    Route::post('logout', [AgentAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:agent')->group(function () {
        Route::get('dashboard', function () {
            return view('agent.dashboard');
        })->name('dashboard');
    });
});
