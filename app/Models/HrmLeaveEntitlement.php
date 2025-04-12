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

    public function employee()
    {
        return $this->belongsTo(Staff::class,'employee_id');
    } public function LeaveType()
    {
        return $this->belongsTo(HrmLeaveTypes::class,'leave_type_id');
    }




}
