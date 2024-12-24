<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camlapse extends Model
{
    use HasFactory;

    protected $table = "camlapses";

    protected $fillable = [
        'name',
        'camera_id',
        'purpose',
        'video_fps',
        'between_time_start',
        'between_time_end',
        'stop_datetime',
        'cron_min',
        'cron_hour',
        'cron_day',
        'cron_weekday',
        'cron_month',
    ];

    public function getCronAttribute(): string
    {
        return sprintf(
            "%s %s %s %s %s",
            $this->cron_min ?? '*',    // min (0 - 59)
            $this->cron_hour ?? '*',   // hour (0 - 23)
            $this->cron_day ?? '*',    // day of month (1 - 31)
            $this->cron_weekday ?? '*', // month (1 - 12)
            $this->cron_month ?? '*',  // day of week (0 - 7) (Sunday=0 or 7)
        );
    }

    public const MEMORY_PERIOD_DAY = 1;
    public const MEMORY_PERIOD_WEEK = 2;
    public const MEMORY_PERIOD_MONTH = 3;
    public const MEMORY_PERIOD_YEAR = 4;

    protected function casts(): array
    {
        return [
            'stop_datetime' => 'datetime:Y-m-dTH:i',
            'video_fps' => 'integer',
            'between_time_start' => 'datetime:H:i',
            'between_time_end' => 'datetime:H:i',
        ];
    }

    public static function deactivateAll()
    {
        Camlapse::where('is_active', true)
            ->update([
                'is_active' => false
            ]);
    }

    public function deactivate()
    {
        $this->is_active = false;
        $this->save();
    }

    public function activate()
    {
        $this->is_active = true;
        $this->save();
    }

    public function getFormAttribute()
    {
        return [
            'name' => [
                'title' => 'Name',
                'type' => 'text',
                'required' => true,
                'default' => '',
                'value' => $this->name ?? '',
            ],
            'purpose' => [
                'title' => 'Purpose',
                'type' => 'text',
                'required' => false,
                'default' => '',
                'value' => $this->purpose ?? '',
            ],
            'camera_id' => [
                'type' => 'select',
                'source' => 'devices',
                'source_index_name' => 'id',
                'source_display_name' => 'name',
                'title' => 'Select Camera',
                'required' => true,
                'value' => $this->camera_id ?? '',
            ],
            'video_fps' => [
                'title' => 'Video FPS',
                'type' => 'number',
                'required' => true,
                'default' => '2',
                'value' => $this->video_fps ?? 2,
            ],
            'between_time_start' => [
                'title' => 'Start time of day restriction',
                'type' => 'time',
                'required' => false,
                'value' => $this->between_time_start?->format("H:i") ?? '00:00',
            ],
            'between_time_end' => [
                'title' => 'End time of day restriction',
                'type' => 'time',
                'required' => false,
                'value' => $this->between_time_end?->format("H:i") ?? '23:59',
            ],
            'stop_datetime' => [
                'title' => 'Stop datetime',
                'type' => 'datetime-local',
                'required' => false,
                'default' => '',
                'value' => $this->stop_datetime ?? '',
            ],
            'cron_min' => [
                'title' => 'Any particular minute within each hour?',
                'type' => 'text',
                'required' => true,
                'info' => "Example: '*' or 0-59",
                'value' => $this->cron_min ?? '*',
            ],
            'cron_hour' => [
                'title' => 'Any particular hour within each day?',
                'type' => 'text',
                'required' => true,
                'info' => "Example: '*' or 0-23",
                'value' => $this->cron_hour ?? '*',
            ],
            'cron_day' => [
                'title' => 'Any particular day?',
                'type' => 'text',
                'required' => true,
                'info' => "Example: '*' or 1-31",
                'value' => $this->cron_day ?? '*',
            ],
            'cron_weekday' => [
                'title' => 'Any particular weekday?',
                'type' => 'text',
                'required' => true,
                'info' => "Example: '*' or 0-7 (Sunday=0 or 7)",
                'value' => $this->cron_weekday ?? '*',
            ],
            'cron_month' => [
                'title' => 'Any particular month?',
                'type' => 'text',
                'required' => true,
                'info' => "Example: '*' or 1-12",
                'value' => $this->cron_month ?? '*',
            ],
        ];
    }
}
