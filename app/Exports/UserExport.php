<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

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
        return User::all()->map(function($user) {
            return[
                'ID' => $user->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Role' => $user->role,
                'Address' => $user->address,
                'Phone Number' => $user->phone_number,
                'Created At' => Carbon::parse($user->created_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'Updated At' => Carbon::parse($user->updated_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ];
        });
    }
}
