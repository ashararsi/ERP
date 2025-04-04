<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchCheckpoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_process_id',
        'name',
        'unit_id',
        'standard_value',
        'actual_value',
        'is_approved',
        'notes',
        'checked_by',
        'checked_at'
    ];

    public function batchProcess()
    {
        return $this->belongsTo(BatchProcess::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
