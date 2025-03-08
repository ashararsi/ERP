<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReceiptNoteItem extends Model
{
    use HasFactory;
    protected $table = 'good_receipt_note_items';
    protected $fillable=['good_receipt_note_id','product_id','quantity_received','status'];



    public function p_items()
    {
        return $this->belongsTo(PurchaseOrderItem::class,'product_id');
    }

}
