<?php

namespace App\Models;

use App\Models\Relation\HasUnits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory,HasUnits;
    
    protected $table = 'products';
    protected $fillable = ['name','image','description','price','packing_id','product_code','sku','unit_id','quantity'];


    public function packing()
    {
        return $this->belongsTo(Packing::class,'packing_id');

    }

//    protected static function booted()
//    {
//        static::creating(function ($product) {
//            $prefix = 'PRD';
//            $latestId = static::max('id') + 1; // or use UUIDs or any other logic
//            $product->product_code = $prefix . str_pad($latestId, 6, '0', STR_PAD_LEFT);
//        });
//    }


}
