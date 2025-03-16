<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class AccountGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/account_groups.json'));

        // Decode JSON data into an array
        $accountGroups = json_decode($json, true);
//

        // Insert all account groups at once
        DB::table('account_groups')->insert($accountGroups);
    }
}
