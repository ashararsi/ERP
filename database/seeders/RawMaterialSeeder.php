<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load the JSON file
        $json = File::get(database_path('data/raw_materials.json'));

        // Decode JSON data into an array
        $rawMaterials = json_decode($json, true);

        // Insert all raw materials at once
        DB::table('raw_materials')->insert($rawMaterials);
    }
}
