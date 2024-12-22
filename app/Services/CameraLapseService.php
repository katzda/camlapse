<?php

namespace App\Services;

use Carbon\Carbon;
use Cron\CronExpression;
use App\Models\LapseModel;
use App\Models\HardwareModel;

class CameraLapseService {

    public function isDue(LapseModel $camlapse, Carbon $now)
    {
        $cron = new CronExpression($camlapse->cron); //https://github.com/dragonmantank/cron-expression
        // 5 custom conditions
        if (!$camlapse->is_active) {
            return false;
        }

        if (!is_null($camlapse->stop_datetime) && $now->greaterThanOrEqualTo($camlapse->stop_datetime)) {
            return false;
        }

        if ($now->gt($camlapse->between_time_end)) {
            return false;
        }

        if ($now->lt($camlapse->between_time_start)) {
            return false;
        }

        if (!$cron->isDue($now)) {
            return false;
        }

        return true;
    }

    public function saveCameraSnapshot(LapseModel $camlapse, Carbon $now, string &$error): bool
    {
        $hardware = HardwareModel::find($camlapse->camera_id);

        if(is_null($hardware)){
            $error = "No device found";
            exit;
        }

        // Define the temporary file path
        $dir = 'timelapse/' . $camlapse->id . "/photos";

        if (!is_dir(public_path($dir))) {
            mkdir(public_path($dir), 0777, true);
        }

        $photo = '/' . str_replace(" ", "T", $now->toDateTimeString()) . '.jpg';

        $cmd = "ffmpeg -f v4l2 -i $hardware->device -frames:v 1 " . public_path($dir . $photo);
        $output = null;
        $exitCode = null;
        exec($cmd, $output, $exitCode);

        if ($exitCode !== 0) {
            return false;
        }

        //TODO adjust cam settings: v4l2-ctl -d /dev/video2 --list-ctrls

        return true;
    }
}
