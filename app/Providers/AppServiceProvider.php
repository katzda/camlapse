<?php

namespace App\Providers;

use App\Events\CrunchVideoEvent;
use App\Jobs\CrunchVideo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('Carbon::now', function(Application $app){
            return Carbon::now();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            CrunchVideoEvent::class,
            CrunchVideo::class,
        );
    }
}
