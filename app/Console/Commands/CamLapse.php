<?php

namespace App\Console\Commands;

use App\Models\HardwareModel;
use Carbon\Carbon;
use App\Models\LapseModel;
use Cron\CronExpression;
use Illuminate\Console\Command;

class CamLapse extends Command
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

    function isDue(LapseModel $camlapse, Carbon $now)
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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $camlapses = LapseModel::all();
        $now = Carbon::now();

        $cam = HardwareModel::find($camlapses[0]->camera_id);

        if(is_null($cam)){
            $this->error("No device found");
            exit;
        }
        $os_device_handle = HardwareModel::find($camlapses[0]->camera_id)->device;
        $output = shell_exec("ffmpeg " . public_path('test.jpg') . " -d " . $os_device_handle);

        foreach ($camlapses as $index => $camlapse) {
            if ($this->isDue($camlapse, $now)) {
                if ($this->saveCameraSnapshot($camlapse, $now, $error)) {
                    $this->info($camlapse->name . ": snap!");
                    $this->updateVideo($camlapse);
                } else {
                    $this->error($error);
                }
            }
        }
    }

    private function saveCameraSnapshot(LapseModel $camlapse, Carbon $now, string &$error): bool
    {
        // Run the first command to get the device
        $error = shell_exec("v4l2-ctl --list-devices 1>/dev/null");

        if (!empty($error)) {
            return false;
        }

        $os_device_handle = HardwareModel::find($camlapse->camera_id)->device;

        // Define the temporary file path
        $dir = 'timelapse/' . $camlapse->id . "/photos";

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

    private function updateVideo(LapseModel $camlapse)
    {
        $baseDir = 'timelapse/' . $camlapse->id;
        $abs_path = public_path($baseDir . "/photos");

        if (!is_dir(public_path($baseDir))) {
            mkdir(public_path($baseDir), 0777, true);
        }

        $photos = scandir($abs_path);
        $photos = array_filter($photos, function ($filename) {
            return str_ends_with($filename, '.jpg');
        });

        $photos = array_map(function ($filename) use ($abs_path) {
            return $abs_path . '/' . $filename;
        }, $photos);

        # Generate the input file list for ffmpeg
        sort($photos);

        $file_list = public_path($baseDir . "/filelist.txt");
        $video_dir = public_path($baseDir);

        if (file_exists($file_list)) {
            unlink($file_list);
        }

        touch($file_list);

        $handle = fopen($file_list, "w");
        foreach ($photos as $file) {
            fwrite($handle, "file '$file'\n");
        }
        fclose($handle);


        shell_exec("ffmpeg -f concat -safe 0 -r $camlapse->video_fps -i $file_list -c:v libx264 -pix_fmt yuv420p -y $video_dir/video.mp4");
        unlink($file_list);
    }
}
