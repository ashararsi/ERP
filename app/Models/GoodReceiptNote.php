<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReceiptNote extends Model
{
    use HasFactory;

    protected $table = 'good_receipt_notes';
    protected $fillable = ['grn_number',  'purchase_order_id','receipt_date','status', 'total_amount', 'notes'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $lastOrder = GoodReceiptNote::latest('id')->first();
            $nextNumber = $lastOrder ? intval(substr($lastOrder->grn_number, -4)) + 1 : 1;
            $order->grn_number = 'GRN-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
