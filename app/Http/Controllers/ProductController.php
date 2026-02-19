<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return view('user.products.index', compact('products'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('user.products.show', compact('product'));
    }

}
