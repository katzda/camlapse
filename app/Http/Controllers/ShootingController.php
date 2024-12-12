<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use App\Services\CameraSettingsService;

class ShootingController extends Controller
{

    public function snapshot(
        int $hardware,
        CameraSettingsService $service
    )
    {
        $snaphotData = $service->GetSnaphot($hardware);

        return response($snaphotData, 200)
            ->header('Content-Type', 'image/jpeg');
    }
}
