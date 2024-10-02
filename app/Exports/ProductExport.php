<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID',
            'Category',
            'Name',
            'Description',
            'Price',
            'Stock',
            'Created At',
            'Updated At',
        ];
    }

    public function collection()
    {
        return Product::with('category')->select('id', 'category_id', 'name', 'description', 'price', 'stock', 'created_at', 'updated_at')
            ->get()
            ->map(function ($product) {
                return[
                    'id' => $product->id,
                    'category_name' => $product->category?->name ?? 'No Category',
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'created_at' => $product->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                    'updated_at' => $product->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                ];
            });
    }
}
