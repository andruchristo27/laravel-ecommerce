@extends('layouts.admin')

@section('content')
    <h2 class="mt-3">Add New Product</h2>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="images">Product Images</label>
            <input type="file" name="images[]"  class="form-control" multiple required>
            <small class="form-text text-muted">Anda dapat memilih lebih dari 1 file.</small>
        </div>
        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
@endsection