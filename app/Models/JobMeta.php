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
        'reference_id',
        'type',
        'duration',
        'created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        // Set the default `created_at` timestamp in milliseconds if it's not provided
        static::creating(function ($jobMeta) {
            if (!$jobMeta->created_at) {
                $jobMeta->created_at = round(microtime(true) * 1000);  // Unix timestamp in milliseconds
            }
        });
    }

    protected function casts(): array
    {
        return [
            'camlapse_id' => 'integer',
            'reference_id' => 'integer',
            'duration' => 'integer',
            'created_at' => 'datetime:Y-m-d H:i',
        ];
    }

    public static function isLastFinished($lapse_id): bool
    {
        $job = JobMeta::where('camlapse_id', '=', $lapse_id)
            ->orderBy('created_at', 'DESC')
            ->value('type');

        return empty($job) || $job == 'end';
    }
}
