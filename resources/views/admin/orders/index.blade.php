@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'Orders Management')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-6">
        ❌ {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h2 class="font-bold">All Orders</h2>
    </div>
    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Order #</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Customer</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Phone</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Total</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr class="border-t border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-3 text-sm font-bold text-orange-600">{{ $order->order_number }}</td>
                    <td class="px-6 py-3 text-sm">{{ $order->name }}</td>
                    <td class="px-6 py-3 text-sm">{{ $order->phone }}</td>
                    <td class="px-6 py-3 text-sm font-semibold">₨{{ number_format($order->total, 0) }}</td>

                    {{-- Status Badge --}}
                    <td class="px-6 py-3">
                        @php
                            $colors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'preparing' => 'bg-purple-100 text-purple-700',
                                'delivered' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="{{ $colors[$order->status] ?? 'bg-slate-100 text-slate-700' }} px-2 py-1 rounded text-xs font-bold uppercase">
                            {{ $order->status }}
                        </span>
                    </td>

                    {{-- Actions: View + Status Dropdown --}}
                    <td class="px-6 py-3 text-sm">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="text-orange-600 hover:underline font-medium text-xs">
                                View
                            </a>

                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status"
                                        onchange="this.form.submit()"
                                        class="text-xs border border-slate-300 rounded px-2 py-1 focus:border-orange-500 outline-none cursor-pointer">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-400">No orders yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $orders->links() }}</div>
</div>

@endsection