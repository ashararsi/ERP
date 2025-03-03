<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id', 'raw_material_id', 'quantity', 'unit_id', 'unit_price', 'subtotal'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function RawMaterial()
    {
        return $this->belongsTo(RawMaterials::class, 'raw_material_id');
    }

}
