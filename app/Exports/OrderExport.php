<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'Total price',
            'Status',
            'Payment type',
            'VA Nnumber',
            'Bank',
            'Acquirer',
            'User',
            'Items',
        ];
    }
    public function collection()
    {
        return Order::select('id', 'user_id', 'total_price', 'status', 'payment_type', 'va_number', 'bank', 'acquirer')
        ->with(['items', 'user:id,name'])
        ->get()
        ->map(function($order) {
            $order->items_list = $order->items->map(fn($item) => $item->product->name . ' (' . $item->quantity . ')')->join(', ');
            $order->user_name = $order->user->name ?? 'Unknown'; 
            return $order;
        });
    }
}
