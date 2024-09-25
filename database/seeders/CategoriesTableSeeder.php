<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Electronics', 'description' => 'Gadgets and devices', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Clothing', 'description' => 'Apparel and accessories', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Home & Garden', 'description' => 'Furniture and decor', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}