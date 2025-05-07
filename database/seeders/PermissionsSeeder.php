<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
/**
 * Author:Aziz
 * Make permission dynamic 
 */
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = config('permission_list');

        foreach ($permissions as $parent => $childPermissions) {
            $parentPermission = Permission::firstOrCreate(
                ['name' => $parent, 'guard_name' => 'web'],
                ['main' => 1, 'parrent_id' => 0]
            );

            foreach ($childPermissions as $permission) {
                Permission::firstOrCreate(
                    ['name' => $permission, 'guard_name' => 'web'],
                    ['main' => 0, 'parrent_id' => $parentPermission->id]
                );
            }
        }
    }
}
