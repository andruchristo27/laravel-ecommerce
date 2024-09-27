@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>User Detail: {{ $user->name }}</h2>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ $user->role }}</p>
    
    <h4>Order History</h4>
    <table id="table" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>Rp {{ $order->total_price }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
