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
        'tax_percent', 'tax_amount', 'net_amount'
    ];

    public function salesOrder(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
}
