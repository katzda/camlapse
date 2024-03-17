<?php

use App\Http\Controllers\CamLapseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CamLapseController::class, "index"]);

Route::resources([
    'camlapse' => CamLapseController::class
]);