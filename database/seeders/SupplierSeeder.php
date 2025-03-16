<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
// Load the JSON file
        $json = File::get(database_path('data/suppliers.json'));

        // Decode JSON data into an array
        $suppliers = json_decode($json, true);

        // Insert all raw materials at once
        Supplier::insert($suppliers);
    }
}
