<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LombaRegistrationController;
use App\Http\Controllers\EdukasiController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    Route::post(
        '/dashboard/home',
        [DashboardController::class, 'storeHome']
    )->name('dashboard.home.store');
    
    Route::resource('lomba', LombaController::class);
    Route::resource('berita', BeritaController::class)
        ->parameters([
            'berita' => 'berita'
        ]);

    // daftar peserta berdasarkan lomba
    Route::get(
        '/pendaftaran-lomba/{lomba}',
        [LombaRegistrationController::class, 'index']
    )->name('registration.index');

    // update status peserta
    Route::patch(
        '/pendaftaran-lomba/{registration}',
        [LombaRegistrationController::class, 'updateStatus']
    )->name('registration.update');

    //export
    Route::get(
        '/registrations/{lomba}/export',
        [LombaRegistrationController::class, 'export']
    )->name('registration.export');

    //edukasi route
    Route::resource('edukasi', EdukasiController::class);

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
