<?php

namespace App\Helpers;

use App\Models\Logs;
use Illuminate\Support\Facades\Gate;

class Helper
{

    public static function logs($table_name, $event_trigger,$event_description,$username)
    {
        Logs::create([
            'table_name'=>$table_name,
            'event_trigger'=>$event_trigger,
            'event_description'=>$event_description,
            'username'=>$username,
            'created_at'=>date('Y-m-d h:i:s'),
            'updated_at'=>date('Y-m-d h:i:s'),

        ]);
    }

    public static function canAccessAny(string $group): bool
    {
        $permissions = config("permission_list.$group", []);
        $hasPermission = collect($permissions)->some(fn($permission) => Gate::allows($permission));
        // dd($permissions, $hasPermission); 
        return $hasPermission;
    }
}
