<?php

namespace Database\Seeders;

use App\Models\Ledger;
use App\Models\Processe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load the JSON file
        $json = File::get(database_path('data/processes.json'));

        // Decode JSON data into an array
        $processes = json_decode($json, true);

        // Insert all processes at once
        Processe::insert($processes);
    }
}
