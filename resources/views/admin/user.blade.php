@extends('layouts.admin')

@section('content')
    <h2 class="mt-3">User</h2>
    <div class="row">
        
    </div>

    <h4>Recent Orders</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>Rp {{ $order->total_price }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
