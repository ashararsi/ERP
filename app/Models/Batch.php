<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'batches';
    protected $fillable = [
        'formulation_id',
        'batch_code',
        'batch_name',
        'batch_date',
        'product_name',
        'mfg_date',
        'total_qty',
        'production_date',
        'expiry_date',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($batch) {
            if (empty($batch->batch_code)) {
                // Get the last batch code and increment
                $lastBatch = static::withTrashed()->latest('id')->first();
                $lastNumber = $lastBatch ? intval(substr($lastBatch->batch_code, -4)) : 0;
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

                $batch->batch_code = 'BATCH-' . $newNumber;
            }
        });
    }
}
