<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@mail.com',
            'password' => 'Password123#',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User 1',
            'email' => 'user1@mail.com',
            'password' => 'Password123#',
            'role' => 'user',
        ]);
    }
}
