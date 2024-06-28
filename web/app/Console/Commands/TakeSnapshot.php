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
    protected $description = 'Check timelapse crons and take due snapshots';

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
                $this->updateVideo($camlapse);
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
        $dir = 'images/'.$camlapse->id."/photos";

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }

        // capture the image
        shell_exec("fswebcam ". Storage::path($dir.$file) ." -d " . $device);

        return true;
    }

    private function updateVideo(CamLapse $camlapse) {
        $baseDir = Storage::path("images/".$camlapse->id."/");
        $photos = glob($baseDir . "photos/*.jpg", GLOB_BRACE);
        $output_dir = $baseDir . "video/";

        if (!Storage::exists($output_dir)) {
            Storage::makeDirectory($output_dir);
        }

        $total_images = count($photos);
        $video_length = 3;
        $frame_rate = round($total_images / $video_length, 2);

        # Generate the input file list for ffmpeg
        sort($photos);
        $file_list = $baseDir . "filelist.txt";
        $handle = fopen($file_list, "w");
        foreach ($photos as $file) {
            fwrite($handle, "file '$file'\n");
        }
        fclose($handle);

        shell_exec("ffmpeg -f concat -safe 0 -r $frame_rate -i $file_list -c:v libx264 -pix_fmt yuv420p $output_dir/video.mp4");
        unlink($file_list);
    }
}
