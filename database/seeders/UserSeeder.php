<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'fullname' => fake()->name(),
                'username' => fake()->unique()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'), // Default password
                'phone' => fake()->unique()->phoneNumber(),
                'address' => fake()->address(),
                'gender' => fake()->numberBetween(0, 1), // 0: Female, 1: Male
                'birthday' => fake()->date(),
                'role' => fake()->numberBetween(1, 3), // Example roles: 1-Admin, 2-Editor, 3-User
                'status' => fake()->numberBetween(0, 1), // 0: Inactive, 1: Active
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}