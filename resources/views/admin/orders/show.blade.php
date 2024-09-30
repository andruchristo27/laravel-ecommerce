@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Order Detail: #{{ $order->id }}</h2>
    <p><strong>User:</strong> {{ $order->user->name }}</p>
    <p><strong>Total Price:</strong> Rp {{ $order->total_price }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Created At:</strong> {{ $order->created_at }}</p>

    <h3>Payment Details</h3>
    <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
    <p><strong>Payment Type:</strong> {{ ucfirst($order->payment_type) }}</p>
    <p><strong>Transaction Status:</strong> {{ ucfirst($order->transaction_status) }}</p>

    @if($order->payment_type === 'bank_transfer')
        <p><strong>Virtual Account Number:</strong> {{ $order->va_number }}</p>
        <p><strong>Bank:</strong> {{ $order->bank }}</p>
    @elseif(in_array($order->payment_type, ['gopay', 'shopeepay']))
        <p><strong>Acquirer:</strong> {{ $order->acquirer }}</p>
        <p><strong>Payment Reference No:</strong> {{ $order->reference_no }}</p>
    @elseif($order->payment_type === 'qris')
        <p><strong>QRIS Data:</strong> {{ $order->qris_data }}</p>
    @endif

    <h4>Order Items</h4>
    <table id="table" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
