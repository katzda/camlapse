<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CamLapseController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', [CamLapseController::class, "index"]);

Route::withoutMiddleware([VerifyCsrfToken::class])->group(function(){
    Route::resources([
        'camlapse' => CamLapseController::class
    ]);
});