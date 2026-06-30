<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LombaRegistrationController;

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

    Route::resource('lomba', LombaController::class);
    Route::resource('berita', BeritaController::class)
        ->parameters([
            'berita' => 'berita'
        ]);

    // Halaman card lomba
    Route::get(
        '/pendaftaran-lomba',
        [LombaRegistrationController::class, 'lombaList']
    )->name('registration.lomba');

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

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
