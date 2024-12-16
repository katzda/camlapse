<?php

namespace App\Console\Commands;

use App\Models\HardwareModel;
use Carbon\Carbon;
use App\Models\LapseModel;
use App\Services\CameraLapseService;
use Cron\CronExpression;
use Illuminate\Console\Command;

class CamLapse extends Command
{
    protected $signature = 'app:snapshot';
    protected $description = 'Check timelapse crons and take due snapshots';

    public function handle()
    {
        $camlapses = LapseModel::all();
        $now = app()->make('Carbon::now');
        $cameraLapseService = app()->make(CameraLapseService::class);

        foreach ($camlapses as $index => $camlapse) {
            if ($cameraLapseService->isDue($camlapse, $now)) {

                $error = "";

                if ($cameraLapseService->saveCameraSnapshot($camlapse, $now, $error)) {
                    $this->info($camlapse->name . ": snap!");
                    $cameraLapseService->updateVideo($camlapse);
                } else {
                    $this->error($error);
                }
            }
        }
    }
}
