<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class OrderExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'ID',
            'User Name',
            'Total price',
            'Status',
            'Payment type',
            'VA Nnumber',
            'Bank',
            'Acquirer',
            'Items',
            'created_at', 
            'updated_at',
        ];
    }
    public function collection()
    {
        return Order::select('id', 'user_id', 'total_price', 'status', 'payment_type', 'va_number', 'bank', 'acquirer', 'created_at', 'updated_at')
        ->with(['items', 'user:id,name'])
        ->get()
        ->map(function($order) {
            return[
                'ID' => $order->id,
                'User' => $order->user->name ?? 'Unknown',
                'Total price '=> $order->total_price,
                'Status' => $order->status,
                'Payment type' => $order->payment_type,
                'VA Nnumber' => $order->va_number,
                'Bank' => $order->bank,
                'Acquirer' => $order->acquirer,
                'Items' => $order->items->map(fn($item) => $item->product->name . ' (' . $item->quantity . ')')->join(', '),
                'created_at' => Carbon::parse($order->created_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'), 
                'updated_at' => Carbon::parse($order->updated_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ];
        });
    }
}
