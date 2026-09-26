<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('menuItem')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->menuItem->price * $item->quantity;
        });

        $deliveryFee = $cartItems->count() > 0 ? 100 : 0;
        $total = $subtotal + $deliveryFee;

        return view('cart.index', compact('cartItems', 'subtotal', 'deliveryFee', 'total'));
    }

    public function add(Request $request, MenuItem $menuItem)
    {
        $request->validate(['quantity' => 'integer|min:1|max:20']);
        $quantity = $request->quantity ?? 1;

        $cart = Cart::where('user_id', auth()->id())
            ->where('menu_item_id', $menuItem->id)
            ->first();

        if ($cart) {
            $cart->update(['quantity' => $cart->quantity + $quantity]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'menu_item_id' => $menuItem->id,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', $menuItem->name . ' added to cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['quantity' => 'required|integer|min:1|max:20']);
        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated!');
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();
        return back()->with('success', 'Item removed from cart!');
    }
}