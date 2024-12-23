<?php

namespace App\Jobs;

use App\Models\JobMeta;
use App\Models\LapseModel;
use Illuminate\Bus\Queueable;
use App\Events\CrunchVideoEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CrunchVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(){
        $this->queue = 'camera';
    }

    private function insertMeta(int $camlapse_id, int $reference_id, string $type, ?int $duration):void
    {
        JobMeta::insert([
            'camlapse_id' => $camlapse_id,
            'reference_id' => $reference_id,
            'type' => $type,
            'duration' => $duration,
        ]);
    }

    /**
     * Execute the job.
     */
    public function handle(CrunchVideoEvent $crunchVideoEvent): void
    {
        $isLastFinished = JobMeta::isLastFinished($crunchVideoEvent->lapseModelId);

        if(!$isLastFinished){
            return;
        }

        $camlapse = LapseModel::find($crunchVideoEvent->lapseModelId);

        $this->insertMeta($camlapse->id, $crunchVideoEvent->referenceId, 'start', null);

        $start_ms = microtime(true);
        $abs_path = public_path("/timelapse/$camlapse->id/photos");

        if (!is_dir($abs_path)) {
            mkdir($abs_path, 0777, true);
        }

        $photos = scandir($abs_path);
        $photos = array_filter($photos, function ($filename) {
            return str_ends_with($filename, '.jpg');
        });

        $photos = array_map(function ($filename) use ($abs_path) {
            return "$abs_path/$filename";
        }, $photos);

        # Generate the input file list for ffmpeg
        sort($photos);

        $file_list = $abs_path . "/filelist.txt";
        $video_dir = "$abs_path/..";

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

        $end_ms = microtime(true);

        $this->insertMeta($camlapse->id, $crunchVideoEvent->referenceId, 'end', $end_ms - $start_ms);
    }
}
