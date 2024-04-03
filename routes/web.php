<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\User\BloodSupplementController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate']);

Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->name('user.')->prefix('/user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/verified', [DashboardController::class, 'verified'])->name('verified');
    Route::post('/verified', [DashboardController::class, 'verified']);
    Route::post('/get-bidan', [DashboardController::class, 'getBidan'])->name('get-bidan');
    Route::post('/createPregnantHistory', [DashboardController::class, 'createPregnancyHistory'])->name('create-hpht');

    Route::resource('/schedule-supplement', BloodSupplementController::class);
});
