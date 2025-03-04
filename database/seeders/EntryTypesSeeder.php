<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EntryTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('entry_types')->insert([
            [
                'name' => 'Journal Voucher',
                'code' => 'GJV',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::parse('2021-03-17 12:11:49'),
                'updated_at' => Carbon::parse('2021-03-17 12:11:49'),
                'deleted_at' => null,
            ],
            [
                'name' => 'Cash Receipt Voucher',
                'code' => 'CRV',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::parse('2021-03-17 12:11:49'),
                'updated_at' => Carbon::parse('2021-03-17 12:11:49'),
                'deleted_at' => null,
            ],
            [
                'name' => 'Cash Payment Voucher',
                'code' => 'CPV',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::parse('2021-03-17 12:11:49'),
                'updated_at' => Carbon::parse('2021-03-17 12:11:49'),
                'deleted_at' => null,
            ],
            [
                'name' => 'Bank Receipt Voucher',
                'code' => 'BRV',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::parse('2021-03-17 12:11:49'),
                'updated_at' => Carbon::parse('2021-03-17 12:11:49'),
                'deleted_at' => null,
            ],
            [
                'name' => 'Bank Payment Voucher',
                'code' => 'BPV',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::parse('2021-03-17 12:11:49'),
                'updated_at' => Carbon::parse('2021-03-17 12:11:49'),
                'deleted_at' => null,
            ],
            [
                'name' => 'Fee Voucher',
                'code' => 'FV',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => Carbon::parse('2021-03-17 12:11:49'),
                'updated_at' => Carbon::parse('2021-03-17 12:11:49'),
                'deleted_at' => null,
            ],
        ]);
    }
}
