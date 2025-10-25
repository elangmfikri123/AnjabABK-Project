<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama' => 'Admin Example',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
        ]);

        User::create([
            'nama' => 'Operator Example',
            'username' => 'operator',
            'email' => 'operator@example.com',
            'password' => Hash::make('operator123'),
            'role' => 'Operator',
        ]);
    }
}
