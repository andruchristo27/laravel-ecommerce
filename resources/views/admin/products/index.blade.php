@extends('layouts.admin')

@section('content')
    <h2 class="mt-3">Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Images</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>Rp {{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @foreach ($product->images as $image)
                            <img src="{{ Storage::url($image->image_url) }}" alt="Product Image" style="width: 50px; height: auto;">
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
