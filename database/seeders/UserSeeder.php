<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        // Add an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'first_name' => 'admin@admin.com',
            'last_name' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        $user = User::find(1);
        $roles = ['Admin'];
        $user->assignRole($roles);



        $roles = Role::pluck('name')->toArray(); // Fetch all role names

        foreach ($roles as $roleName) {
            for ($i = 1; $i <= 5; $i++) { // Create 5 users per role
                $user = User::create([
                    'name' => "$roleName User $i",
                    'email' => strtolower($roleName) . "$i@example.com",
                    'first_name' => "$roleName User",
                    'last_name' => "Test $i",
                    'password' => Hash::make('12345678'),
                ]);

                $user->assignRole($roleName);
            }
        }



    }
}
