<?php

namespace App\Services;

use App\Jobs\TakeTestSnapshot;

class CameraSettingsService {

    public function GetSnaphot(int $hardware_id)
    {
        $fifoPath = config('camera.fifo_path.snapshot');

        if(!file_exists($fifoPath)){
            shell_exec("mkfifo $fifoPath");
        }

        //  TakeTestSnapshot::dispatch(1, config('camera.fifo_storage_path'))->onQueue('camera');
        TakeTestSnapshot::dispatch($hardware_id)->onQueue('camera');

        $file = file_get_contents($fifoPath);

        shell_exec("rm $fifoPath");

        return $file;
    }
}
