<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\User\BloodSupplementController;
use App\Http\Controllers\User\CheckAncController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'authenticate']);

    Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
    Route::post('/registration', [RegistrationController::class, 'registration']);
});

Route::middleware(['auth', 'preventUnverifiedAccess'])->group(function () {
    Route::name('user.')->prefix('/user')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/verified', [DashboardController::class, 'verified'])->name('verified')
            ->middleware(['redirectIfVerified'])
            ->withoutMiddleware('preventUnverifiedAccess');
        Route::post('/verified', [DashboardController::class, 'verified']);
        Route::post('/get-bidan', [DashboardController::class, 'getBidan'])->name('get-bidan');
        Route::post('/createPregnantHistory', [DashboardController::class, 'createPregnancyHistory'])->name('create-hpht');

        // Kunjungan ANC Ibu Hamil
        Route::resource('/check-anc', CheckAncController::class);

        // Jadwal Tablet Tambah Darah
        Route::resource('/schedule-supplement', BloodSupplementController::class);
    });

    Route::name('midwife.')->prefix('/midwife')->group(function () {
        Route::get('/verified', fn () => view('app.midwife.index'))->name('verified')
            ->middleware('redirectIfVerified')
            ->withoutMiddleware('preventUnverifiedAccess');
    });

    Route::name('doctor.')->prefix('/doctor')->group(function () {
        Route::get('/verified', fn () => view('app.doctor.index'))->name('verified')
            ->middleware('redirectIfVerified')
            ->withoutMiddleware('preventUnverifiedAccess');
    });

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->withoutMiddleware('preventUnverifiedAccess');
});
