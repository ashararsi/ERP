<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'first_name' => 'admin@admin.com',
            'last_name' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'usman User',
            'email' => 'imusmanali44@gmail.com',
            'first_name' => 'imusmanali44@gmail.com',
            'last_name' => 'imusmanali44@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'usman User',
            'email' => 'teammember@gmail.com',
            'first_name' => 'imusmanali44@gmail.com',
            'last_name' => 'imusmanali44@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'team_member',
        ]);
        User::create([
            'name' => 'coach User',
            'email' => 'coach@gmail.com',
            'first_name' => 'coach@gmail.com',
            'last_name' => 'coach@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'coach',
        ]);
        $user=User::find(1);

        $roles =  ['admin'];
        $user->assignRole($roles);

    }
}
