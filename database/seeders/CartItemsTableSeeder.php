<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartItemsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cart_items')->insert([
            [
                'cart_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cart_id' => 1,
                'product_id' => 2,
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
