<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'text', 'icons', 'long_description', 'status', 'image'];
    protected $table = "settings";
}
