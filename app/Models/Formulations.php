<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formulations extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "formulations";
    protected $fillable = ['formula_name', 'description'];


    public function formulationDetail()
    {
        return $this->hasMany(FormulationDetail::class, 'formulation_id');
    }


}
