@extends('layouts.admin')

@section('content')
    <h2 class="mt-3">Edit Product</h2>
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

    <div class="mt-2 d-flex flex-wrap">
        @foreach ($product->images as $image)
            <div class="image-container mb-2 mr-2">
                <img src="{{ Storage::url($image->image_url) }}" alt="Product Image" style="width: 100px; height: auto;">
                <form action="{{ route('products.images.destroy', [$product, $image]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        @endforeach
    </div>

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control select2" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>
        
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>
        
        <div class="form-group">
            <label for="images">Product Images</label>
            <input type="file" name="images[]" class="form-control" multiple>
            <small class="form-text text-muted">You can add more images. Current images:</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
@endsection
