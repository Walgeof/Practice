<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
        return view('user.categories.index', compact('categories'));
    }


    public function show(Request $request, Category $category)
    {
        $sort = in_array($request->sort, ['name', 'price']) ? $request->sort : 'name';
        $direction = in_array($request->direction, ['asc', 'desc']) ? $request->direction : 'asc';

        $category->load(['products' => fn($q) => $q->orderBy($sort, $direction)]);
        return view('user.categories.show', compact('category', 'sort', 'direction'));
    }
}
