<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $table = 'holidays';

    protected $fillable = [
        'holiday_name',
        'holiday_date',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
