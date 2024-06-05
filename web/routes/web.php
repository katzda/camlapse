<?php

use App\Jobs\TestJob;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CamLapseController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', [CamLapseController::class, "index"]);

Route::get('/dispatch', function () {
    TestJob::dispatch();
    return 'Job dispatched!';
});

Route::withoutMiddleware([VerifyCsrfToken::class])->group(function(){
    Route::resources([
        'camlapse' => CamLapseController::class
    ]);
    Route::post('camlapse/{camlapse}/activate', [CamLapseController::class, 'activate'])->name('camlapse.activate');
    Route::post('camlapse/{camlapse}/deactivate', [CamLapseController::class, 'deactivate'])->name('camlapse.deactivate');
});