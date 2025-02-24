<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

                $role = Role::create(['name' =>'admin', 'guard_name' => 'web']);
                            $permissions=Permission::pluck("id");
                        $role->givePermissionTo($permissions);




//        DB::table('roles')->insert(
//        [
//            'name' => "user",
//            'guard_name' => 'web'
//
//        ]
//        ); DB::table('roles')->insert(
//        [
//            'name' => "Hr",
//            'guard_name' => 'web'
//
//        ]
//        );
    }
}
