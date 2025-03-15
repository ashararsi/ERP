<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $table="erp_vendor";
    protected $fillable = [
        'vendor_name',
        'cnic',
        'ntn',
        'salestaxno',
        'email',
        'contact',
        'addresss', // Note: This might be a typo. Should it be 'address'?
        'created_at',
        'updated_at',
        'updated_by',
        'type',
        'category',
        'service_type',
        'remarks',
        'acc_no',
        'pra_no',
        'pra_type',
        'sales_tax',
        'bank_branch_code',
        'bank_branch_name',
    ];
}
