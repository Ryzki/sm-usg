<?php

use App\Http\Controllers\Admin\AreaController;
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

//Namespace DOCTOR
use App\Http\Controllers\Doctor\DashboardController as DoctorController;

//Namespace ADMIN
use App\Http\Controllers\Admin\DashboardController as AdminController;
use App\Http\Controllers\Admin\SubDistrictController;
use App\Http\Controllers\Admin\UserControler;

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
        Route::get('/dashboard', [DoctorController::class, 'index'])->name('dashboard');
        Route::post('/get-schedule-user', [MidwifeDashboard::class, 'getScheduleUser'])->name('get_schedule_user');
        Route::get('/control-users', [DoctorController::class, 'controlAllUsers'])->name('control_all_users');
    });

    Route::middleware('role:Admin')->name('admin.')->prefix('/admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::prefix('/users')->controller(UserControler::class)->group(function () {
            Route::get('/', 'index')->name('users.index');
            Route::post('/users/store', 'store')->name('users.store');
            Route::post('/change-role-user', [UserControler::class, 'changeRole'])->name('changeRole');
        });
        Route::prefix('/sub-districts')->controller(SubDistrictController::class)->group(function () {
            Route::get('/', 'index')->name('sub-district.index');
            Route::post('/store', 'store')->name('sub-district.store');
            Route::put('/update/{subdistrict}', 'update')->name('sub-district.update');
            Route::post('/change_stat', 'changeStat')->name('sub-district.change_stat');
        });
        Route::prefix('/areas')->controller(AreaController::class)->group(function () {
            Route::get('/', 'index')->name('areas.index');
            Route::post('/store', 'store')->name('areas.store');
            Route::put('/update/{areas}', 'update')->name('areas.update');
            Route::put('/delete/{areas}', 'destroy')->name('areas.destroy');
            Route::post('/change_stat', 'changeStat')->name('areas.change_stat');
        });
    });

    Route::get('/verification', [VerificationController::class, 'index'])->name('verification')->middleware('verified');
    Route::post('/verification', [VerificationController::class, 'postVerification']);
    Route::post('/get-bidan', [DashboardController::class, 'getBidan'])->name('get_bidan');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
