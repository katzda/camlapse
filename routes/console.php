<?php

use App\Console\Commands\CamLapse;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CamLapse::class)->everyMinute();
