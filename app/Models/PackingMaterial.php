<?php

namespace App\Models;

use App\Models\Relation\HasUnits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingMaterial extends Model
{
    use HasFactory,HasUnits;

    protected $fillable = ['name', 'category_id', 'unit_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
