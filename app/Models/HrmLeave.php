<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmLeave extends Model
{
    use HasFactory;
    protected $table = 'hrm_leaves';

    protected $fillable = [
        'leave_request_id',
        'employee_id',
        'leave_type_id',
        'work_shift_id',
        'leave_status_id',
        'leave_date',
        'start_time',
        'end_time',
        'shift',
        'hours',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
