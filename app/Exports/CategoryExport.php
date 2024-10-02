<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class CategoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Created At',
            'Updated At',
        ];
    }

    public function collection()
    {
        return Category::all()->map(function($category) {
            return[
                'ID' => $category->id,
                'Name' => $category->name,
                'Description' => $category->description,
                'Created At' => Carbon::parse($category->created_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'Updated At' => Carbon::parse($category->updated_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ];
        });
    }
}
