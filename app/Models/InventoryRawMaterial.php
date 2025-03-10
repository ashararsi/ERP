<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryRawMaterial extends Model
{
    use HasFactory;

    protected $table = 'inventory_raw_materials';
    protected $fillable = ['product_id', 'quantity_available', 'unit_price', 'unit_of_measurement', 'total_cost'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_of_measurement');
    }
}
