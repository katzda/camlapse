<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\CamLapse;
use Cron\CronExpression;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TakeSnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:snapshot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $camlapses = CamLapse::all();
        $now = Carbon::now();

        foreach($camlapses as $index => $camlapse){
            $cron = new CronExpression($camlapse->cron); //https://github.com/dragonmantank/cron-expression
            // 5 custom conditions
            if(!$camlapse->is_active){
                continue;
            }

            if(!is_null($camlapse->stop_datetime) && $now->greaterThanOrEqualTo($camlapse->stop_datetime)){
                continue;
            }

            if($now->gt($camlapse->between_time_end)){
                continue;
            }

            if($now->lt($camlapse->between_time_start)){
                continue;
            }

            if(!$cron->isDue($now)){
                continue;
            }

            if($this->saveCameraSnapshot($camlapse, $now)){
                $this->info($camlapse->name.": snap!");
            }
        }
    }

    private function saveCameraSnapshot(CamLapse $camlapse, Carbon $now) : bool{
        // Run the first command to get the device
        $error = shell_exec("v4l2-ctl --list-devices 1>/dev/null");

        if(!empty($error)){
            $this->error($error);
            return false;
        }

        $device = shell_exec("v4l2-ctl --list-devices 2>/dev/null | grep Arducam_8mp -A 1 | grep /dev | xargs");
        // $device = shell_exec("v4l2-ctl --list-devices 2>/dev/null | grep Arducam_8mp -A 1 | grep /dev/video3 | xargs"); // no output
        // $device = shell_exec("v4l2-ctl --list-devices 2>/dev/null | grep Arducam_8mp -A 1 | grep /dev/media1 | xargs"); // no ouput
        $device = trim($device);

        // Define the temporary file path
        $file = '/' . str_replace(" ", "T", $now->toDateTimeString()) . '.jpg';
        $dir = 'images/'.$camlapse->id;

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }

        // capture the image
        shell_exec("fswebcam ". Storage::path($dir.$file) ." -d " . $device);

        return true;
    }
}
