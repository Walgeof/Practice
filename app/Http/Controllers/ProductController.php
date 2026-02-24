<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = in_array($request->sort, ['name', 'price']) ? $request->sort : 'name';
        $direction = in_array($request->direction, ['asc', 'desc']) ? $request->direction : 'asc';

        $products = Product::with('category')->orderBy($sort, $direction)->get();
        return view('user.products.index', compact('products', 'sort', 'direction'));
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
