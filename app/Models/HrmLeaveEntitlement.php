<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmLeaveEntitlement extends Model
{
    use HasFactory;
    protected $table = 'hrm_leave_entitlements';

    protected $fillable = [
        'employee_id',
        'no_of_days',
        'days_used',
        'start_date',
        'end_date',
        'credited_date',
        'leave_type_id',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
