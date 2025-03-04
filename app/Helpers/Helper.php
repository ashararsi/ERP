<?php

namespace App\Helpers;

use App\Models\Logs;

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
}
