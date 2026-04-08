<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Product::latest();

        //Search
        if($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        // index
        $products = $query->paginate(50);
        return view('products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create', [
            'categories' => \App\Models\Category::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:products,code',
            'name' => 'required|string|max:255',
            'category_slug' => 'required|exists:categories,slug',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        //Store image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Lakukan store
        Product::create($validated);

        // Redirect
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'categories' => \App\Models\Category::latest()->get()
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:products,code,' . $product->id,
            'name' => 'required|string|max:255',
            'category_slug' => 'required|exists:categories,slug',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::delete($product->image);
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Lakukan update
        $product->update($validated);

        // Redirect
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        if ($product->image) {
            Storage::delete($product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
