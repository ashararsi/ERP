<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_number','unit_id', 'supplier_id', 'order_date', 'delivery_date', 'status', 'total_amount', 'notes'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $lastOrder = PurchaseOrder::latest('id')->first();
            $nextNumber = $lastOrder ? intval(substr($lastOrder->po_number, -4)) + 1 : 1;
            $order->po_number = 'PO-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
