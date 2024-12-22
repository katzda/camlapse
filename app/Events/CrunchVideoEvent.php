<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;

class CrunchVideoEvent
{
    use Dispatchable, InteractsWithSockets;

    public int $referenceId;

    public function __construct(
        public int $lapseModelId
    ){
        $this->referenceId = rand(0, 255);
    }
}
