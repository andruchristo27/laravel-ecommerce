<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductImage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\PersistRelations;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $product = Product::create([
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'stock' => $row['stock'],
        ]);

        $images = array_map('trim', explode(',', $row['images']));

        foreach ($images as $imageUrl) {
            ProductImage::create([
                'image_url' => $imageUrl,
                'product_id' => $product->id,
            ]);
        }
    }
}
