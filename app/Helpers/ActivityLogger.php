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
            'module' => $currentUrl = url()->current(),
            'description' => $description,
            'data' => $data,
            'ip_address' => request()->ip(),
            'name' => Auth::check() ? Auth::user()->name : null,
        ]);
    }
}

