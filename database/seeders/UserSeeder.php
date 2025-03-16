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
        $user = User::find(1);
        $roles = ['Admin'];
        $user->assignRole($roles);

    }
}
