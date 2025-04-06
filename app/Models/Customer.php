<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = ['name', 'email', 'phone', 'address', 'created_by', 'agent_id', 'status'];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
