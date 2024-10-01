<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Role',
            'Address',
            'Phone Number',
            'Created At',
            'Updated At',
        ];
    }

    public function collection()
    {
        return User::all();
    }
}
