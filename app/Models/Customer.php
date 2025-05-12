<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = ['name', 'email', 'phone', 'address', 'created_by', 'agent_id', 'status'
        ,'cnic','ntn','city_name','customer_code','stn'];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($customer) {
    //         $customer->customer_code = self::generateCustomerCode();
    //     });
    // }


    // public static function generateCustomerCode()
    // {
    //     $latestId = optional(self::latest('id')->first())->id ?? 0;
    //     $nextId = $latestId + 1;
    //     return 'CUST-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    // }
}
