<?php

namespace App\Jobs;

use App\Models\HardwareModel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TakeTestSnapshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $hardware_id,
        public $fifoPath
    ){
        $this->queue = 'camera';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $hardwareModel = HardwareModel::find($this->hardware_id);

        $os_device_handle = $hardwareModel->device;

        //TODO adjust cam settings: v4l2-ctl -d /dev/video2 --list-ctrls

        $testCommand = "v4l2-ctl --list-devices | grep $hardwareModel->device";
        $output = null;
        $exitCode = null;
        exec($testCommand, $output, $exitCode);
        if (empty($output) || $exitCode !== 0) {
            return;
        }

        //shell exec does not provide exit code, but returns console output like a regular function
        shell_exec("ffmpeg -f v4l2 -i $os_device_handle -frames:v 1 -f image2pipe -y $this->fifoPath");
    }
}
