<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'code',
        'level',
        'parent_id',
        'account_type_id',
        'status',
        'parent_type',
        'company_id',
        'city_id',
        'branch_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Relationships
     */

    // Company Relation
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Branch Relation
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

//    // City Relation
//    public function city()
//    {
//        return $this->belongsTo(City::class, 'city_id');
//    }

    // Account Type Relation
    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    // Parent Relationship (if hierarchical structure)
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
