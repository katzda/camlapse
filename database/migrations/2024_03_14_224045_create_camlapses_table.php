<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('camlapses', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('camera_id');
            $table->string('name', 255)->unique();
            $table->string('purpose')->default('');
            $table->smallInteger('video_fps')->default(2);
            $table->time('between_time_start')->default('00:00');
            $table->time('between_time_end')->default('23:59');
            $table->dateTime('stop_datetime')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('cron_min');
            $table->string('cron_hour');
            $table->string('cron_day')->default('*');
            $table->string('cron_month')->default('*');
            $table->string('cron_weekday')->default('*');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camlapses');
    }
};
