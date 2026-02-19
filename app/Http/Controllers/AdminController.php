<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $this->authorize('admin');

        $stats = [
            'products_count' => Product::count(),
            'categories_count' => Category::count(),
            'pending_orders_count' => Order::where('status', 'pending')->count(),
            'pending_orders' => Order::with(['user', 'items'])->where('status', 'pending')
            ->latest()->take(10)->get(),
            'recent_products' => Product::with('category')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
