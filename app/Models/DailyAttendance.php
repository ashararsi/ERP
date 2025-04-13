<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyAttendance extends Model
{
    use HasFactory;

    protected $table = 'daily_attendance';


    protected $fillable = [
        'user_id',
        'date',
        'time_in',
        'time_out',
        'created_at',
        'updated_at',
        'branch_id',
        'status',
        'remarks',
        'month',
    ];


    public function user()
    {

        return $this->belongsTo('App\Models\Staff', 'user_id', 'id');
    }
}
