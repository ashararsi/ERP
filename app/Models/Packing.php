<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    use HasFactory;
    protected $fillable = [
        'packing_type',
        'quantity',
        'unit',
        'display_name',
        'image_path',
        'is_active',
        'description'
    ];

    // Common packing types for curd products
    public const PACKING_TYPES = [
        'bottle' => 'Bottle',
        'box' => 'Box',
        'pouch' => 'Pouch',
        'tablet' => 'Tablet',
        'cup' => 'Cup',
        'jar' => 'Jar',
        'tin' => 'Tin',
    ];


    /**
     * Get the full packing description (e.g., "500ml Bottle")
     */
//    public function getFullDescriptionAttribute(): string
//    {
//        $displayName = $this->display_name ? " ({$this->display_name})" : '';
//        return "{$this->quantity}{$this->unit} " .
//            ucfirst($this->packing_type) . $displayName;
//    }

    /**
     * Scope active packings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by packing type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('packing_type', $type);
    }

    /**
     * Get all packing types with counts
     */
    public static function getPackingTypesWithCounts()
    {
        return static::select('packing_type')
            ->selectRaw('count(*) as count')
            ->groupBy('packing_type')
            ->pluck('count', 'packing_type');
    }

    public function units()
    {
        return $this->belongsTo(Unit::class, 'unit');
    }
}
