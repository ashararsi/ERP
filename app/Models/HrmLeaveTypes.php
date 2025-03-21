<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmLeaveTypes extends Model
{
    use HasFactory;
    protected $table = 'hrm_leave_types';

    protected $fillable = [
        'name',
        'permitted_days',
        'condition',
        'allowed_number',
        'allowed_type',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
