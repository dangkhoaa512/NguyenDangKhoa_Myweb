<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $name = fake()->unique()->words(2, true);
            DB::table('brands')->insert([
                'brandname' => ucfirst($name),
                'slug' => Str::slug($name),
                'status' => fake()->numberBetween(0, 1),
                'sort_order' => $i,
                'description' => fake()->sentence(30),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}