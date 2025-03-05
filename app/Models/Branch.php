<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'company_id', 'name', 'city_id', 'country_id', 'branch_code',
        'phone', 'cell', 'address', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');

    }
}
