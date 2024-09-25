<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 2000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 1,
                'product_id' => 2,
                'quantity' => 2,
                'price' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
