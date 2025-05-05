<?php

namespace App\Models\Relation;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUnits 
{
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}