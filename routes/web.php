<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LapseModelController;
use App\Http\Controllers\ShootingController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::withoutMiddleware([VerifyCsrfToken::class])->group(function () {
    Route::resources([
        'camlapse' => LapseModelController::class
    ]);

    Route::get('/', [HardwareController::class, "index"])->name('home');
    Route::post('devices/refresh', [HardwareController::class, 'autoUpdate'])->name('devices.refresh');
    Route::post('camlapse/{camlapse}/activate', [LapseModelController::class, 'activate'])->name('camlapse.activate');
    Route::post('camlapse/{camlapse}/deactivate', [LapseModelController::class, 'deactivate'])->name('camlapse.deactivate');
    Route::get('hardware_settings/{hardware}', [SettingsController::class, 'show'])->name('settings.show');
    Route::get('hardware_settings/{hardware}/snapshot', [ShootingController::class, 'snapshot'])->name('shoot.snapshot');
});
