<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsIssuance extends Model
{
    use HasFactory;
    protected $fillable = [
        'batch_id',
//        'raw_material_id',
        'issued_quantity',
        'wastage_quantity',
        'issued_by',
        'issued_date',
        'qa_status',
        'remarks',
    ];

    protected $table='goods_issuance';
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }
}
