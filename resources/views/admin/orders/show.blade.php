@extends('layouts.admin')
@section('title', 'Order Details')
@section('page-title', 'Order #' . $order->order_number)

@section('content')
<div class="max-w-3xl">

    <a href="{{ route('admin.orders.index') }}" class="text-orange-600 font-medium text-sm">← Back to Orders</a>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mt-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Customer Info --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mt-4">
        <h2 class="font-bold text-lg mb-4">Customer Details</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-slate-500 text-xs uppercase font-semibold mb-1">Customer</p>
                <p class="font-medium">{{ $order->name }}</p>
            </div>
            <div>
                <p class="text-slate-500 text-xs uppercase font-semibold mb-1">Phone</p>
                <p class="font-medium">{{ $order->phone }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-slate-500 text-xs uppercase font-semibold mb-1">Address</p>
                <p class="font-medium">{{ $order->address }}</p>
            </div>
            @if($order->notes)
                <div class="col-span-2">
                    <p class="text-slate-500 text-xs uppercase font-semibold mb-1">Notes</p>
                    <p class="font-medium">{{ $order->notes }}</p>
                </div>
            @endif
            <div>
                <p class="text-slate-500 text-xs uppercase font-semibold mb-1">Payment Method</p>
                <p class="font-medium">{{ strtoupper($order->payment_method) }}</p>
            </div>
            <div>
                <p class="text-slate-500 text-xs uppercase font-semibold mb-1">Payment Status</p>
                <p class="font-medium">{{ ucfirst($order->payment_status) }}</p>
            </div>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mt-4">
        <h2 class="font-bold text-lg mb-4">Order Items</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="text-left pb-2 text-xs font-semibold text-slate-500 uppercase">Item</th>
                    <th class="text-center pb-2 text-xs font-semibold text-slate-500 uppercase">Price</th>
                    <th class="text-center pb-2 text-xs font-semibold text-slate-500 uppercase">Qty</th>
                    <th class="text-right pb-2 text-xs font-semibold text-slate-500 uppercase">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr class="border-b border-slate-100">
                        <td class="py-3 font-medium">{{ $item->item_name }}</td>
                        <td class="py-3 text-center">₨{{ number_format($item->price, 0) }}</td>
                        <td class="py-3 text-center">{{ $item->quantity }}</td>
                        <td class="py-3 text-right font-semibold">₨{{ number_format($item->total, 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 pt-4 border-t border-slate-200 space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-slate-600">Subtotal</span>
                <span class="font-medium">₨{{ number_format($order->subtotal, 0) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-600">Delivery Fee</span>
                <span class="font-medium">₨{{ number_format($order->delivery_fee, 0) }}</span>
            </div>
            <div class="flex justify-between pt-2 border-t border-slate-100">
                <span class="font-bold text-base">Total</span>
                <span class="text-orange-600 font-extrabold text-lg">₨{{ number_format($order->total, 0) }}</span>
            </div>
        </div>
    </div>

    {{-- Status Update --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mt-4">
        <h2 class="font-bold text-lg mb-4">Update Order Status</h2>

        <p class="text-sm text-slate-500 mb-4">
            Current Status:
            @php
                $colors = [
                    'pending' => 'bg-yellow-100 text-yellow-700',
                    'confirmed' => 'bg-blue-100 text-blue-700',
                    'preparing' => 'bg-purple-100 text-purple-700',
                    'delivered' => 'bg-green-100 text-green-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                ];
            @endphp
            <span class="{{ $colors[$order->status] ?? 'bg-slate-100' }} px-3 py-1 rounded-full text-xs font-bold uppercase">
                {{ $order->status }}
            </span>
        </p>

        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex gap-3">
            @csrf @method('PATCH')

            <select name="status" class="flex-1 px-4 py-3 border border-slate-300 rounded-lg focus:border-orange-500 outline-none font-medium">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>👨‍🍳 Preparing</option>
                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>🚚 Delivered</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
            </select>

            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold whitespace-nowrap">
                Update Status
            </button>
        </form>
    </div>

</div>
@endsection