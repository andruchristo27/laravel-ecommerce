<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_images')->insert([
            [
                'product_id' => 1,
                'image_url' => 'https://example.com/images/smartphone.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'image_url' => 'https://example.com/images/tshirt.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
