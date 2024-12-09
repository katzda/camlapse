<?php

namespace App\Services;

use App\Models\HardwareModel;
use Carbon\Carbon;

class CameraSettingsService {

    public function GetSnaphot(HardwareModel $hardwareModel, Carbon $now){

        // Run the first command to get the device
        $error = shell_exec("v4l2-ctl --list-devices 1>/dev/null");

        if (!empty($error)) {
            return false;
        }

        $os_device_handle = HardwareModel::find($camlapse->camera_id)->device;


        if (!is_dir(public_path($dir))) {
            mkdir(public_path($dir), 0777, true);
        }

        $photo = '/' . str_replace(" ", "T", $now->toDateTimeString()) . '.jpg';

        //TODO: ffmpeg -f v4l2 -i /dev/video2 -frames:v 1 /srv/snapshot.jpg
        shell_exec("ffmpeg " . public_path($dir . $photo) . " -d " . $os_device_handle);

        exec('echo $?', $output);

        dd($output);
        //TODO adjust cam settings: v4l2-ctl -d /dev/video2 --list-ctrls

        return true;
    }
}