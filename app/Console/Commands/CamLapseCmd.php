<?php

namespace App\Console\Commands;

use App\Models\Camlapse;
use Illuminate\Console\Command;
use App\Events\CrunchVideoEvent;
use App\Services\CameraLapseService;

class CamLapseCmd extends Command
{
    protected $signature = 'app:snapshot';
    protected $description = 'Check timelapse crons and take due snapshots';

    public function handle()
    {
        $camlapses = Camlapse::all();
        $now = app()->make('Carbon::now');
        $cameraLapseService = app()->make(CameraLapseService::class);

        foreach ($camlapses as $index => $camlapse) {
            if ($cameraLapseService->isDue($camlapse, $now)) {

                $error = "";

                if ($cameraLapseService->saveCameraSnapshot($camlapse, $now, $error)) {
                    $this->info($camlapse->name . ": snap!");
                    CrunchVideoEvent::dispatch($camlapse->id);
                } else {
                    $this->error($error);
                }
            }
        }
    }
}
