<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobMeta extends Model
{
    use HasFactory;

    protected $table = "job_meta";

    public $timestamps = false;

    protected $fillable = [
        'camlapse_id',
        'type',
        'duration',
        'timestamp'
    ];

    protected function casts(): array
    {
        return [
            'camlapse_id' => 'integer',
            'duration' => 'integer',
            'timestamp' => 'timestamp',
        ];
    }

    public function getTimestampAttribute($value)
    {
        return Carbon::createFromTimestampMs($value)->format('Y-m-d H:i:s.v');
    }

    public static function isLastFinished($lapse_id): bool
    {
        $job = JobMeta::where('camlapse_id', '=', $lapse_id)
            ->orderBy('timestamp', 'DESC')
            ->limit(1)
            ->value('type');

        return empty($job) || $job == 'end';
    }
}
