<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_number', 'order_date', 'customer_id', 'customer_po_no',
        'customer_po_date', 'city', 'payment_terms', 'sales_rep_id',
        'delivery_date', 'sub_total', 'total_discount', 'total_tax',
        'advance_tax', 'net_total', 'notes', 'status','total_sale_tax','further_sale_tax','total_cal_amount'
        ,'all_included_tax'
    ];

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function salesRep()
    {
        return $this->belongsTo(User::class, 'sales_rep_id');
    }


    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $lastOrder = self::orderBy('id', 'desc')->first();
            $nextNumber = $lastOrder ? ((int) str_replace('SO-', '', $lastOrder->order_number)) + 1 : 1;
            $order->order_number = 'SO-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        });
    }
}
