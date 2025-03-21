<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmLeaveRequests extends Model
{
    use HasFactory;
    protected $table = 'hrm_leave_requests';

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'work_shift_id',
        'leave_status',
        'start_date',
        'end_date',
        'total_days',
        'applied_date',
        'comments',
        'leave_type_data',
        'work_shift_data',
        'single_duration',
        'single_shift',
        'single_hours_start',
        'single_hours_end',
        'single_hours_duration',
        'partial_days',
        'all_days_duration',
        'all_days_shift',
        'all_days_hours_start',
        'all_days_hours_end',
        'all_days_hours_duration',
        'starting_duration',
        'starting_shift',
        'starting_hours_start',
        'starting_hours_end',
        'starting_hours_duration',
        'ending_duration',
        'ending_shift',
        'ending_hours_start',
        'ending_hours_end',
        'ending_hours_duration',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
