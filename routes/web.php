<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LombaRegistrationController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\EdukasiVideoController;
use App\Http\Controllers\HomeHeroController;
use App\Http\Controllers\ProfileController;


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

    // Hero
    Route::post(
        '/dashboard/heroes',
        [HomeHeroController::class, 'store']
    )->name('dashboard.hero.store');

    Route::put(
        '/dashboard/heroes/{hero}',
        [HomeHeroController::class, 'update']
    )->name('dashboard.hero.update');

    Route::delete(
        '/dashboard/heroes/{hero}',
        [HomeHeroController::class, 'destroy']
    )->name('dashboard.hero.destroy');

    Route::post(
        '/dashboard/youtube',
        [HomeHeroController::class, 'storeYoutube']
    )->name('dashboard.youtube.store');

    // Route::put(
    //     '/dashboard/youtube',
    //     [HomeHeroController::class, 'updateYoutube']
    // )->name('dashboard.youtube.update');
    // End Hero

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
    Route::resource('edukasi-video', EdukasiVideoController::class);

    // edit profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Logout 
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
