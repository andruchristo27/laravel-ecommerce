<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query();

    if ($request->has('category')) {
        $query->where('category_id', $request->category);
    }

    if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
        $query->orderBy('price', $request->sort);
    }

    $products = $query->get();

    return response()->json([
        'status' => 'success',
        'message' => 'products list fetched',
        'data' => $products,
        'total' => $products->count(), 
    ], 200);
}
}
