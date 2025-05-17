<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // Admin
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'image' => 'admin.jpg',
            'phone_number' => '0790000000',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Instructors
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => "Instructor $i",
                'email' => "instructor$i@example.com",
                'password' => Hash::make('password123'),
                'role' => 'instructor',
                'image' => "instructor$i.jpg",
                'phone_number' => '079' . rand(1000000, 9999999),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Parents
        for ($i = 1; $i <= 20; $i++) {
            DB::table('users')->insert([
                'name' => "Parent $i",
                'email' => "parent$i@example.com",
                'password' => Hash::make('password123'),
                'role' => 'parent',
                'image' => "parent$i.jpg",
                'phone_number' => '078' . rand(1000000, 9999999),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
