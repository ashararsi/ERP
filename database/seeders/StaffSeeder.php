<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run()
    {
        $json = File::get(database_path('data/staff.json'));

        // Decode JSON data into an array
        $staff = json_decode($json, true);

        // Insert all ledger entries at once
        Staff::insert($staff);
    }
}
