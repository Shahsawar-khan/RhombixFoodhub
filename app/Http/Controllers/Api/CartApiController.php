<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('menuItem')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->menuItem->price * $item->quantity;
        });

        return response()->json([
            'items' => $cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->menuItem->name,
                    'price' => $item->menuItem->price,
                    'quantity' => $item->quantity,
                    'image' => $item->menuItem->image ? asset('storage/' . $item->menuItem->image) : null,
                    'subtotal' => $item->menuItem->price * $item->quantity,
                ];
            }),
            'subtotal' => $subtotal,
            'delivery_fee' => $cartItems->count() > 0 ? 100 : 0,
            'total' => $subtotal + ($cartItems->count() > 0 ? 100 : 0),
            'count' => $cartItems->sum('quantity'),
        ]);
    }

    public function add(Request $request, MenuItem $menuItem)
    {
        $quantity = $request->input('quantity', 1);

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

        return response()->json([
            'success' => true,
            'message' => $menuItem->name . ' added to cart!',
            'count' => Cart::where('user_id', auth()->id())->sum('quantity'),
        ]);
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cart->update(['quantity' => $request->input('quantity', 1)]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated!',
            'count' => Cart::where('user_id', auth()->id())->sum('quantity'),
        ]);
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed!',
            'count' => Cart::where('user_id', auth()->id())->sum('quantity'),
        ]);
    }

    public function count()
    {
        return response()->json([
            'count' => Cart::where('user_id', auth()->id())->sum('quantity'),
        ]);
    }
}