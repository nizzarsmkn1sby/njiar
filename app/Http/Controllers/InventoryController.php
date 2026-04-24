<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::with('category')->latest()->get();
        $categories = \App\Models\Category::all();
        return view('inventory.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        \App\Models\Product::create($data);
        return back()->with('success', 'Product added');
    }

    public function update(Request $request, \App\Models\Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return back()->with('success', 'Product updated');
    }

    public function destroy(\App\Models\Product $product)
    {
        $categoryId = $product->category_id;
        $product->delete();

        // Otomatis hapus kategori jika sudah tidak ada produk di dalamnya
        $category = \App\Models\Category::find($categoryId);
        if ($category && $category->products()->count() === 0) {
            $category->delete();
        }

        return back()->with('success', 'Product deleted');
    }

    public function restock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'supplier' => 'nullable|string',
        ]);

        \App\Models\Restock::create([
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'supplier' => $request->supplier,
            'restock_date' => now(),
        ]);

        $product = \App\Models\Product::find($request->product_id);
        $product->increment('stock', $request->qty);

        return back()->with('success', 'Restock success');
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $category = \App\Models\Category::firstOrCreate(['name' => $request->name]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'category' => $category
            ]);
        }

        return back()->with('success', 'Category ready');
    }

    public function destroyCategory(\App\Models\Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Category is not empty');
        }
        $category->delete();
        return back()->with('success', 'Category deleted');
    }
}
