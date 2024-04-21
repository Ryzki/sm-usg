<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AllowVerifiedAccess;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\PreventUnverifiedAccess;
use App\Http\Controllers\User\CheckAncController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\User\BloodSupplementController;


Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'authenticate']);

    Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
    Route::post('/registration', [RegistrationController::class, 'registration']);
});

Route::middleware(['auth'])->group(function () {
    Route::name('user.')->prefix('/user')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/verified', [DashboardController::class, 'verified'])->name('verified');
        Route::post('/verified', [DashboardController::class, 'verified']);
        Route::post('/get-bidan', [DashboardController::class, 'getBidan'])->name('get-bidan');

        Route::post('/createPregnantHistory', [DashboardController::class, 'createPregnancyHistory'])->name('create-hpht');
        Route::resource('/check-anc', CheckAncController::class);
        Route::get('/check-anc/{name_anc}/{schedule_date}', [CheckAncController::class, 'create'])->name('check-anc.create');
        Route::resource('/schedule-supplement', BloodSupplementController::class);
    });

    Route::name('midwife.')->prefix('/midwife')->group(function () {
        Route::get('/dashboard', fn () => view('app.midwife.index'))->name('verified');
        Route::get('/verified', fn () => view('app.midwife.index'))->name('verified');
    });

    Route::name('doctor.')->prefix('/doctor')->group(function () {
        Route::get('/dashboard', fn () => view('app.midwife.index'))->name('verified');
        Route::get('/verified', fn () => view('app.doctor.index'))->name('verified');
    });

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
