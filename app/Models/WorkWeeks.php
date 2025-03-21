<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkWeeks extends Model
{
    use HasFactory;
    protected $table = 'hrm_work_weeks';

    protected $fillable = [
        'mon',
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'sun',
        'working_days',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
