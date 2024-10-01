<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Imports\ProductImport;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->get();
        return view('admin.products.index', compact('products'));
    }

    public function show(Request $request)
    {
        $query = Product::with('images');

        return DataTables::of($query)
            ->addColumn('images', function ($product) {
                $images = '';
                foreach ($product->images as $image) {
                    $imageUrl = $image->image_url;
                    if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                        $images .= '<img src="'.$imageUrl.'" alt="Product Image" style="width: 50px; height: auto;">';
                    } else {
                        $images .= '<img src="'.Storage::url($imageUrl).'" alt="Product Image" style="width: 50px; height: auto;">';
                    }
                }
                return $images;
            })
            ->addColumn('actions', function ($product) {
                return '
                    <a href="'.route('products.edit', $product).'" class="btn btn-warning">Edit</a>
                    <form action="'.route('products.destroy', $product).'" method="POST" style="display:inline;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['images', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $product = Product::create($request->only(['category_id', 'name', 'description', 'price', 'stock']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create(['product_id' => $product->id, 'image_url' => $path]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $product->update($request->only(['category_id', 'name', 'description', 'price', 'stock']));

        if ($request->hasFile('images')) {
            // $product->images()->delete();
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create(['product_id' => $product->id, 'image_url' => $path]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function search(Request $request) {
        $search = $request->get('q');
    
        $categories = Category::where('name', 'like', "%$search%")
                              ->limit(20)
                              ->get();
    
        return response()->json($categories);
    }

    public function export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ProductImport, $request->file('file'));

        return back()->with('success', 'Products imported successfully.');
    }
}
