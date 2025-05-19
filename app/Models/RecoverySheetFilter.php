<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoverySheetFilter extends Model
{
    use HasFactory;

    protected $fillable = ['serial_no', 'sales_person_id', 'start_date', 'end_date', 'cities', 'areas'];

    public function salesPerson()
{
    return $this->belongsTo(User::class, 'sales_person_id');
}

}
