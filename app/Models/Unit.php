<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

use Spatie\Activitylog\LogOptions;
class Unit extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'units';
    protected $fillable = ['name', 'conversion_factor', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    public function subUnits()
    {
        return $this->hasMany(Unit::class, 'parent_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }
}
