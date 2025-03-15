<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'entry_type_id',
        'entry_id',
        'ledger_id',
        'parent_id',
        'parent_type',
        'voucher_date',
        'amount',
        'dc',
        'narration',
        'instrument_number',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
