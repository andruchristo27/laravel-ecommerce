<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('123456'),
                'role' => 'admin',
                'address' => 'Admin Address',
                'phone_number' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => bcrypt('123456'),
                'role' => 'user',
                'address' => 'User Address',
                'phone_number' => '0987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
