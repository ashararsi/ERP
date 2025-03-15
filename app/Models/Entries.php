<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'voucher_date',
        'cheque_no',
        'cheque_date',
        'invoice_no',
        'invoice_date',
        'bank_name',
        'bank_branch',
        'dr_total',
        'cr_total',
        'narration',
        'remarks',
        'entry_type_id',
        'employee_id',
        'branch_id',
        'department_id',
        'company_id',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function entry_type()
    {
        //return $this->hasMany(Ledgers::class, 'ledger_id', 'id');
        return $this->belongsTo(EntryTypes::class);
    }

    public function getVoucherDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function entry_items()
    {
        return $this->hasMany(EntryItems::class, 'entry_id', 'id');
    }
}
