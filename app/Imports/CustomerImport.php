<?php

namespace App\Imports;

use App\Models\User;
use App\Models\City;
use App\Models\Area;
use App\Models\Customer;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    use \Maatwebsite\Excel\Concerns\Importable;

    public function model(array $row)
    {
        $salesManName = trim(explode('(', $row['sales_man'])[0]);
        $salesManPhone = null;

        if (preg_match('/\((.*?)\)/', $row['sales_man'], $matches)) {
            $salesManPhone = $matches[1];
        }

        $salesManEmail = Str::slug($salesManName, '_') . '@example.com';

        $salesMan = User::firstOrCreate(
            ['email' => $salesManEmail],
            [
                'name' => $salesManName,
                'phone' => $salesManPhone,
                'password' => bcrypt('password'),
            ]
        );

        if (!$salesMan->hasRole('Spo')) {
            $salesMan->assignRole('Spo');
        }

        $city = City::firstOrCreate(
            ['name' => $row['city_name']],
            [
                'country_id' => 1,
                'status' => 1,
            ]
        );

        $area = Area::firstOrCreate(
            ['name' => $row['area_name']],
            [
                'company_id' => 1,
                'status' => 1,
            ]
        );

        Customer::updateOrCreate(
            ['customer_code' => $row['code']],
            [
                'name'           => $row['customers_name'],
                'email'          => null,
                'phone'          => null,
                'address'        => $row['address'],
                'created_by'     => auth()->id() ?? 1,
                'agent_id'       => null,
                'status'         => 1,
                'cnic'           => $row['cnic'],
                'ntn'            => $row['ntn'],
                'city_name'      => $city->name,
                'stn'            => null,
                'spo_id'         => $salesMan->id,
            ]
        );
    }
}
