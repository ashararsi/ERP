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
}
