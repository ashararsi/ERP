<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    use HasFactory;
    protected $table="erp_financial_years";
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
