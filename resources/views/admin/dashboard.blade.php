@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-orange-100 flex items-center justify-center text-2xl">📦</div>
        <div>
            <h3 class="text-2xl font-extrabold">{{ $stats['orders'] }}</h3>
            <p class="text-sm text-slate-500 font-medium">Total Orders</p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center text-2xl">💰</div>
        <div>
            <h3 class="text-2xl font-extrabold">₨{{ number_format($stats['revenue'], 0) }}</h3>
            <p class="text-sm text-slate-500 font-medium">Revenue</p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center text-2xl">🍽️</div>
        <div>
            <h3 class="text-2xl font-extrabold">{{ $stats['menu_items'] }}</h3>
            <p class="text-sm text-slate-500 font-medium">Menu Items</p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center text-2xl">👥</div>
        <div>
            <h3 class="text-2xl font-extrabold">{{ $stats['customers'] }}</h3>
            <p class="text-sm text-slate-500 font-medium">Customers</p>
        </div>
    </div>

</div>

{{-- RECENT ORDERS --}}
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="font-bold text-slate-700">Recent Orders</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-orange-600 text-sm font-medium hover:underline">View All →</a>
    </div>
    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Order #</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Customer</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Total</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
                <tr class="border-t border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-3 text-sm font-bold text-orange-600">{{ $order->order_number }}</td>
                    <td class="px-6 py-3 text-sm">{{ $order->name }}</td>
                    <td class="px-6 py-3 text-sm font-semibold">₨{{ number_format($order->total, 0) }}</td>
                    <td class="px-6 py-3">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'preparing' => 'bg-purple-100 text-purple-700',
                                'delivered' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="{{ $statusColors[$order->status] ?? 'bg-slate-100' }} px-2 py-1 rounded text-xs font-bold uppercase">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm text-slate-500">{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">No orders yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection