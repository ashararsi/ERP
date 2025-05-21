<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bilty extends Model
{
    use HasFactory;
    protected $fillable = [
        'goods_name',
        'place',
        'bilty_no',
        'bilty_date',
        'courier_date',
        'receipt_no',
        'cartons',
        'fare'
    ];

    protected $casts = [
        'bilty_date' => 'date',
        'courier_date' => 'date',
    ];
    

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }
}
