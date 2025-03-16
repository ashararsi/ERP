<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/ledger.json'));

        // Decode JSON data into an array
        $ledgers = json_decode($json, true);

        // Insert all ledger entries at once
        DB::table('ledgers')->insert($ledgers);
    }
}
