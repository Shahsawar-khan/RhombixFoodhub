<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders — FoodHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

@include('partials.navbar')

<div class="max-w-4xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-extrabold mb-8">📦 My Orders</h1>

    @forelse($orders as $order)
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-4">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <div class="font-bold text-lg text-orange-600">{{ $order->order_number }}</div>
                    <div class="text-xs text-slate-500 mt-1">{{ $order->created_at->format('M d, Y — h:i A') }}</div>
                </div>
                <div>
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
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4 space-y-2">
                @foreach($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span>{{ $item->item_name }} × {{ $item->quantity }}</span>
                        <span class="font-medium">₨{{ number_format($item->total, 0) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-slate-100 mt-4 pt-4 flex justify-between">
                <span class="font-bold">Total</span>
                <span class="text-orange-600 font-extrabold text-lg">₨{{ number_format($order->total, 0) }}</span>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl border p-16 text-center">
            <div class="text-6xl mb-4">📦</div>
            <p class="text-slate-400 text-lg mb-4">No orders yet</p>
            <a href="{{ route('menu.index') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold">Browse Menu</a>
        </div>
    @endforelse

    <div class="mt-6">{{ $orders->links() }}</div>
</div>

</body>
</html>