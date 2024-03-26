<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CamLapse extends Model
{
    use HasFactory;

    protected $table="camlapses";

    protected $fillable = [
        'name',
        'description',
        'fph',
        'between_hour_start',
        'between_hour_end',
        'memory_period',
        'stop_datetime',
    ];

    public const MEMORY_PERIOD_DAY = 1;
    public const MEMORY_PERIOD_WEEK = 2;
    public const MEMORY_PERIOD_MONTH = 3;
    public const MEMORY_PERIOD_YEAR = 4;

    public static function deactivateAll(){
        CamLapse::where('is_active', true)
            ->update([
                'is_active' => false
            ]);
    }
}
