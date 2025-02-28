<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Processe extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'processes';
    protected $fillable=['name','description','sequence_order','image','duration_minutes','remarks','requires_quality_check'];
}
