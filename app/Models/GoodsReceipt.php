<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    use HasFactory;


    protected $fillable = [
        'batch_id',
        'process_id',
        'received_quantity',
        'wastage_quantity',
        'received_by',
        'received_date',
        'qa_status',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function process()
    {
        return $this->belongsTo(ManufacturingProcess::class);
    }
}
