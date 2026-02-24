<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Store a new order using offline payment.
     */
    public function storeOffline(Request $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('status', __('Cart is empty.'));
        }

        $total = collect($cart)->sum(function (array $item) {
            return $item['price'] * $item['quantity'];
        });

        DB::transaction(function () use ($cart, $total) {
            $order = Order::create([
                'user_id'        => auth()->id(),
                'status'         => 'pending',
                'payment_method' => 'offline',
                'total'          => $total,
            ]);

            foreach ($cart as $productId => $item) {
                $order->items()->create([
                    'product_id' => $productId,
                    'name'       => $item['name'],
                    'price'      => $item['price'],
                    'quantity'   => $item['quantity'],
                    'subtotal'   => $item['price'] * $item['quantity'],
                ]);
            }
        });

        session()->forget('cart');

        return redirect()
            ->route('home')
            ->with('status', __('Order placed. The administrator will contact you to complete payment.'));
    }

    /**
     * Mark an order as paid/completed (admin only).
     */
    public function markPaid(Order $order): RedirectResponse
    {
        $this->authorize('admin');

        if ($order->status !== 'completed') {
            $order->update(['status' => 'completed']);
        }

        return redirect()->back()->with('status', __('Order marked as paid.'));
    }
}

