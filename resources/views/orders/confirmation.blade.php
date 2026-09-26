<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed — FoodHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

@include('partials.navbar')

<div class="max-w-3xl mx-auto px-4 py-16">

    <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">✅</div>

        <h1 class="text-3xl font-extrabold mb-3">Order Placed Successfully!</h1>
        <p class="text-slate-500 mb-8">Thank you for your order. We'll start preparing it soon.</p>

        <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 mb-8">
            <div class="text-sm text-slate-500 mb-1">Order Number</div>
            <div class="text-2xl font-extrabold text-orange-600">{{ $order->order_number }}</div>
        </div>

        <div class="text-left bg-slate-50 rounded-xl p-6 mb-8">
            <h3 class="font-bold mb-4">Order Details</h3>

            <div class="space-y-3 mb-4 pb-4 border-b border-slate-200">
                @foreach($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span>{{ $item->item_name }} × {{ $item->quantity }}</span>
                        <span class="font-medium">₨{{ number_format($item->total, 0) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between mb-2 text-sm">
                <span class="text-slate-600">Subtotal</span>
                <span class="font-medium">₨{{ number_format($order->subtotal, 0) }}</span>
            </div>
            <div class="flex justify-between mb-2 text-sm">
                <span class="text-slate-600">Delivery Fee</span>
                <span class="font-medium">₨{{ number_format($order->delivery_fee, 0) }}</span>
            </div>
            <div class="flex justify-between pt-2 border-t border-slate-200">
                <span class="font-bold">Total</span>
                <span class="text-orange-600 font-extrabold">₨{{ number_format($order->total, 0) }}</span>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('orders.my') }}" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl font-bold">My Orders</a>
            <a href="{{ route('menu.index') }}" class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 py-3 rounded-xl font-bold">Order More</a>
        </div>
    </div>
</div>

</body>
</html>