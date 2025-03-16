<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $jsonPath = database_path('seeders/data/suppliers.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("The file suppliers.json does not exist at: {$jsonPath}");
            return;
        }

        $suppliers = json_decode(File::get($jsonPath), true);

        if ($suppliers === null) {
            $this->command->error("Invalid JSON format in suppliers.json");
            return;
        }

        // Add timestamps to each supplier
        $currentTimestamp = Carbon::now();
        $suppliers = array_map(function ($supplier) use ($currentTimestamp) {
            $supplier['created_at'] = $currentTimestamp;
            $supplier['updated_at'] = $currentTimestamp;
            return $supplier;
        }, $suppliers);

        // Insert all records at once
        DB::table('suppliers')->insert($suppliers);

        $this->command->info('Suppliers table seeded successfully!');
    }
}
