<?php

use App\Http\Controllers\DevicesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CamLapseController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::withoutMiddleware([VerifyCsrfToken::class])->group(function () {
    Route::resources([
        'camlapse' => CamLapseController::class
    ]);

    Route::get('/', [DevicesController::class, "index"])->name('home');
    Route::post('devices/refresh', [DevicesController::class, 'update'])->name('devices.refresh');
    Route::post('camlapse/{camlapse}/activate', [CamLapseController::class, 'activate'])->name('camlapse.activate');
    Route::post('camlapse/{camlapse}/deactivate', [CamLapseController::class, 'deactivate'])->name('camlapse.deactivate');
});
