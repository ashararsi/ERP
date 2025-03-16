<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load the JSON file
        $json = File::get(database_path('data/unit.json'));

        // Decode JSON data into an array
        $units = json_decode($json, true);

        // Insert all unit records at once
        DB::table('units')->insert($units);
    }
}
