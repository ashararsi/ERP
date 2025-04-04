<?php

namespace App\Models;
use App\Models\Processe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchProcess extends Model
{
    use HasFactory;


    protected $fillable = [
        'batch_id',
        'process_id',
        'order',
        'remarks',
        'duration_minutes',
        'actual_duration_minutes',
        'start_time',
        'end_time',
        'status'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function process()
    {
        return $this->belongsTo(Processe::class);
    }

    public function checkpoints()
    {
        return $this->hasMany(BatchCheckpoint::class);
    }
}
