<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\Auth\LoginController;

// Namespace USER
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\User\CheckAncController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\EducationController;
use App\Http\Controllers\Auth\RegistrationController;

//Namespace MIDWIFE
use App\Http\Controllers\Midwife\ControlUserController;
use App\Http\Controllers\User\BloodSupplementController;
use App\Http\Controllers\Midwife\DashboardController as MidwifeDashboard;
use App\Http\Controllers\Midwife\ScheduleController;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'authenticate']);

    Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
    Route::post('/registration', [RegistrationController::class, 'registration']);
});

Route::middleware(['auth'])->group(function () {
    Route::middleware('role:Ibu Hamil')->name('user.')->prefix('/user')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/createPregnantHistory', [DashboardController::class, 'createPregnancyHistory'])->name('create-hpht');
        Route::resource('/check-anc', CheckAncController::class)->except('create', 'show');
        Route::get('/check-anc/{name_anc}/{schedule_date}', [CheckAncController::class, 'create'])
            ->name('check-anc.create');
        Route::get('/check-anc/detail/{name_anc}/{schedule_date}', [CheckAncController::class, 'show'])
            ->name('check-anc.show');
        Route::resource('/schedule-supplement', BloodSupplementController::class);
        Route::resource('/chat', ChatController::class);
        Route::resource('/education', EducationController::class);
    });

    Route::middleware('role:Bidan')->name('midwife.')->prefix('/midwife')->group(function () {
        Route::get('/dashboard', [MidwifeDashboard::class, 'index'])->name('dashboard');
        Route::post('/get-schedule-user', [MidwifeDashboard::class, 'getScheduleUser'])->name('get_schedule_user');
        Route::resource('/control-users', ControlUserController::class);
        Route::resource('/schedule-users', ScheduleController::class);
    });

    Route::middleware('role:Dokter')->name('doctor.')->prefix('/doctor')->group(function () {
        Route::get('/dashboard', fn () => view('app.doctor.index'))->name('dashboard');
        Route::get('/verified', fn () => view('app.doctor.index'))->name('verified');
    });

    Route::get('/verification', [VerificationController::class, 'index'])->name('verification')->middleware('verified');
    Route::post('/verification', [VerificationController::class, 'postVerification']);
    Route::post('/get-bidan', [DashboardController::class, 'getBidan'])->name('get_bidan');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
