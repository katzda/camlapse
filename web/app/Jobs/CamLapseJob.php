<?php

namespace App\Jobs;

use App\Events\CamLapseEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CamLapseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public CamLapseEvent $event)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
