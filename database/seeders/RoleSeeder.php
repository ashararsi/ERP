<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\File;

use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
//    public function run()
//    {
//
//                $role = Role::create(['name' =>'admin', 'guard_name' => 'web']);
//                            $permissions=Permission::pluck("id");
//                        $role->givePermissionTo($permissions);
//
//
//
//
////        DB::table('roles')->insert(
////        [
////            'name' => "user",
////            'guard_name' => 'web'
////
////        ]
////        ); DB::table('roles')->insert(
////        [
////            'name' => "Hr",
////            'guard_name' => 'web'
////
////        ]
////        );
//    }


    public function run(): void
    {
        // Load the JSON file
        $json = File::get(database_path('data/roles.json'));

        // Decode JSON data into an array
        $roles = json_decode($json, true);

        // Insert all roles at once
        Role::insert($roles);
    }

}
