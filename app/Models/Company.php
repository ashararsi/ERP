<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'ntn', 'gst', 'gst_type', 'vat',
        'phone', 'fax', 'address', 'logo', 'status', 'created_by',
        'updated_by', 'deleted_by'
    ];
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
