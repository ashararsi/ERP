<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterials extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'raw_materials';
    protected $fillable = ['name', 'unit', 'quantity', 'supplier', 'cost', 'expiry_date'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit');
    }

}
