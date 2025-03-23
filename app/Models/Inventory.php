<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{

    protected $table = 'inventory';

    use HasFactory;
    protected $fillable = [
        'product_id',
        'batch_number',
        'sku',
        'quantity',
        'cost_price',
        'selling_price',
        'expiry_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
