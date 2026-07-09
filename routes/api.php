<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LombasController;
use App\Http\Controllers\Api\BeritasController;
use App\Http\Controllers\Api\LombaRegistrationsController;
use App\Http\Controllers\Api\EdukasisController;
use App\Http\Controllers\Api\HomeSettingsController;

Route::prefix('v1')
    ->name('api.')
    ->group(function () {

        Route::apiResource('lombas', LombasController::class)
            ->only([
                'index',
                'show'
            ]);

        Route::apiResource('beritas', BeritasController::class)
            ->only([
                'index',
                'show'
            ]);

        Route::apiResource('edukasis', EdukasisController::class)
            ->only([
                'index',
                'show'
            ]);
        Route::apiResource('home-settings', HomeSettingsController::class)
            ->only([
                'index',
            ]);
        Route::get(
            'edukasis/{edukasi}/pdf',
            [EdukasisController::class, 'pdf']
        )->name('edukasis.pdf');

        Route::post(
            'lomba-registrations',
            [LombaRegistrationsController::class, 'store']
        );
    });
