@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Order Detail: #{{ $order->id }}</h2>
    <p><strong>User:</strong> {{ $order->user->name }}</p>
    <p><strong>Total Price:</strong> {{ $order->total_price }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Created At:</strong> {{ $order->created_at }}</p>

    <h4>Order Items</h4>
    <table class="table table-striped">
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
