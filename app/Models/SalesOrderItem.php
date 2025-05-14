<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    use HasFactory;


    protected $fillable = [
        'sales_order_id', 'product_id', 'batch_id', 'expiry_date',
        'quantity', 'rate', 'amount', 'discount_percent', 'discount_amount',
        'tax_percent', 'tax_amount', 'net_amount','scheme_discount','trade_discount','special_discount'
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
