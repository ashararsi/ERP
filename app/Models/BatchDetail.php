<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'batch_details';
    protected $fillable = [
        'batch_id',
        'raw_material_id',
        'actual_quantity',
        'operator_initials',
        'qa_initials',
        'in_charge',
    ];
}
