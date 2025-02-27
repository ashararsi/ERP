<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActionLogController extends Controller
{
    public function showLogs() {
        $logs = ActivityLog::with('user')->latest()->get();
        return view('admin.logs.logs', compact('logs'));
    }

}
