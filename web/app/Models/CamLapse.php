<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CamLapse extends Model
{
    use HasFactory;

    protected $table="camlapses";

    protected $fillable = [
        'name',
        'purpose',
        'fph',
        'between_time_start',
        'between_time_end',
        'cron_day',
        'cron_weekday',
        'cron_month',
        'cron_year',
        'stop_datetime',
        'is_active',
    ];

    public const MEMORY_PERIOD_DAY = 1;
    public const MEMORY_PERIOD_WEEK = 2;
    public const MEMORY_PERIOD_MONTH = 3;
    public const MEMORY_PERIOD_YEAR = 4;
    
    protected function casts(): array
    {
        return [
            'stop_datetime' => 'datetime:Y-m-dTH:i',
            'between_time_start' => 'datetime:H:i',
            'between_time_end' => 'datetime:H:i',
        ];
    }

    public static function deactivateAll(){
        CamLapse::where('is_active', true)
            ->update([
                'is_active' => false
            ]);
    }

    public function deactivate(){
        $this->is_active = false;
        $this->save();
    }

    public function activate(){
        $this->is_active = true;
        $this->save();
    }
}
