<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';
    protected $fillable = ['name', 'conversion_factor', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    public function subUnits()
    {
        return $this->hasMany(Unit::class, 'parent_id');
    }
}
