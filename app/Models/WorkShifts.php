<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShifts extends Model
{
    use HasFactory;
    protected $table = 'work_shifts';

    protected $fillable = [
        'name',
        'hours_per_day',
        'shift_start_time',
        'shift_end_time',
        'working_hours_per_day',
        'break_start_time',
        'break_end_time',
        'break_hours_per_day',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
