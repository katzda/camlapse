<?php

use App\Console\Commands\CamLapseCmd;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CamLapseCmd::class)->everyMinute();
