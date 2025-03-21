<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPlans extends Model
{
    use HasFactory;
    protected $table = 'loan_plans';

    protected $fillable = [
        'loan_installment',
        'tenure',
        'extra_pay',
    ];
}
