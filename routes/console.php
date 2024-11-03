<?php

use App\Console\Commands\TakeSnapshot;
use Illuminate\Support\Facades\Schedule;

Schedule::command(TakeSnapshot::class)->everyMinute();
