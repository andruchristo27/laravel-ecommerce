@extends('layouts.admin')

@section('content')
    <h2 class="mt-3">Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#importModal">
        Import Product
    </button>
    <a href="{{ route('export.product') }}" class="btn btn-success mb-3">Export Product</a>

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
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('import.product') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label for="file" class="form-label">Choose Excel File</label>
                    <input type="file" class="form-control" name="file" required>
                </div>
                <a href="{{ asset('templates/product_template.xlsx') }}">Download Template</a>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
