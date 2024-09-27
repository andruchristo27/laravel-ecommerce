@extends('layouts.admin')

@section('content')
    <h2 class="mt-3">Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table id="productTable" class="table table-striped" style="width:100%">
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
            
        </tbody>
    </table>
@endsection
