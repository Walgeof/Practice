<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of products for admin.
     */
    public function index()
    {
        $this->authorize('admin');
        $products = Product::with('category')->orderBy('created_at', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $this->authorize('admin');
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(StoreProductRequest $request)
    {
        $this->authorize('admin');
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        Product::create($data);
        return redirect()->route('admin.products.index')->with('status', __('Product created.'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $this->authorize('admin');
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $this->authorize('admin');
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('admin');
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        } else {
            unset($data['image']);
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('status', __('Product updated.'));
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        $this->authorize('admin');
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('status', __('Product deleted.'));
    }
}
