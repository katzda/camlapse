<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobMeta extends Model
{
    use HasFactory;

    protected $table = "job_meta";

    protected $fillable = [
        'camlapse_id',
        'reference_id',
        'type',
        'duration',
    ];

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
