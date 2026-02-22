<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the contents of the cart.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = collect($cart)->sum(function (array $item) {
            return $item['price'] * $item['quantity'];
        });

        return view('user.cart.index', compact('cart', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('products.index')->with('status', __('Product added to cart.'));
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (! isset($cart[$product->id])) {
            return redirect()->route('cart.index');
        }

        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $cart[$product->id]['quantity'] = $quantity;
        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    /**
     * Clear the cart.
     */
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index');
    }
}

