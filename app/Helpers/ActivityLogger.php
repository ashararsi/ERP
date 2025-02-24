<?php


namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($action, $description = null, $data = [])
    {
        ActivityLog::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'action' => $action,
            'description' => $description,
            'data' => $data,
            'name' => Auth::check() ? Auth::user()->name : null,
        ]);
    }
}

