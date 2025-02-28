<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormulationDetail extends Model
{
    protected $table = 'formulation_detail';
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'formulation_id',
        'raw_material_id',
        'standard_quantity',
        'actual',
    ];



    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterials::class,'raw_material_id');
    }
}
