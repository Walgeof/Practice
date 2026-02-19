<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories for admin.
     */
    public function index()
    {
        $this->authorize('admin');
        $categories = Category::withCount('products')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $this->authorize('admin');
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $this->authorize('admin');
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        Category::create($request->all());
        return redirect()->route('admin.categories.index')->with('status', __('Category created.'));
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        $this->authorize('admin');
        $category->load('products');
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        $this->authorize('admin');
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('admin');
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('status', __('Category updated.'));
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        $this->authorize('admin');
        $category->delete();
        return redirect()->route('admin.categories.index')->with('status', __('Category deleted.'));
    }
}
