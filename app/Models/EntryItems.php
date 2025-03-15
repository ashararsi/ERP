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

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    public function lagder_data()
    {
        //return $this->hasMany(Ledgers::class, 'ledger_id', 'id');
        return $this->belongsTo('App\Models\Admin\Ledgers', 'ledger_id', 'id');
    }

    public function entry()
    {
        return $this->hasOne(Entries::class, 'id', 'entry_id');
    }

    public function vendor_data()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'vendor_id');
    }
}
