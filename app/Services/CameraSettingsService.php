<?php

namespace App\Services;

use App\Jobs\TakeSnapshot;

class CameraSettingsService {

    public function GetSnaphot(int $hardware_id)
    {
        $fifoPath = config('camera.fifo_storage_path');

        if(!file_exists($fifoPath)){
            shell_exec("mkfifo $fifoPath");
        }

        //  TakeSnapshot::dispatch(1, config('camera.fifo_storage_path'))->onQueue('camera');
        TakeSnapshot::dispatch($hardware_id, $fifoPath)->onQueue('camera');

        $file = file_get_contents($fifoPath);

        shell_exec("rm $fifoPath");

        return $file;
    }
}
