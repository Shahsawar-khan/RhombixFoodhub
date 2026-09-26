<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::with('menuItem')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->menuItem->price * $item->quantity;
        });

        $deliveryFee = 100;
        $total = $subtotal + $deliveryFee;

        return view('orders.checkout', compact('cartItems', 'subtotal', 'deliveryFee', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:cod,easypaisa',
        ]);

        $cartItems = Cart::with('menuItem')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->menuItem->price * $item->quantity;
        });

        $deliveryFee = 100;
        $total = $subtotal + $deliveryFee;

        DB::beginTransaction();

        try {
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => auth()->id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'notes' => $request->notes,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $cartItem->menu_item_id,
                    'item_name' => $cartItem->menuItem->name,
                    'price' => $cartItem->menuItem->price,
                    'quantity' => $cartItem->quantity,
                    'total' => $cartItem->menuItem->price * $cartItem->quantity,
                ]);
            }

            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('orders.confirmation', $order->id);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }

    public function confirmation($id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.confirmation', compact('order'));
    }

    public function myOrders()
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.my-orders', compact('orders'));
    }
}