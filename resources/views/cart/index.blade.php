<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart — FoodHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

@include('partials.navbar')

<div class="max-w-6xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-extrabold mb-8">🛒 Your Cart</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-6">❌ {{ session('error') }}</div>
    @endif

    @if($cartItems->count() > 0)
        <div class="grid md:grid-cols-3 gap-8">

            {{-- Cart Items --}}
            <div class="md:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-xl border border-slate-200 p-4 flex gap-4">
                        @if($item->menuItem->image)
                            <img src="{{ asset('storage/' . $item->menuItem->image) }}" class="w-24 h-24 object-cover rounded-lg">
                        @else
                            <div class="w-24 h-24 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center text-white text-3xl">🍽️</div>
                        @endif

                        <div class="flex-1">
                            <h3 class="font-bold mb-1">{{ $item->menuItem->name }}</h3>
                            <p class="text-orange-600 font-bold mb-3">₨{{ number_format($item->menuItem->price, 0) }}</p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <input type="number" 
                                           value="{{ $item->quantity }}" 
                                           min="1" 
                                           max="20"
                                           data-url="{{ route('api.cart.update', $item) }}"
                                           class="ajax-cart-qty w-16 text-center border border-slate-300 rounded-lg py-1">
                                    <span class="text-xs text-slate-400">auto-updates</span>
                                </div>

                                <button type="button"
                                        data-url="{{ route('api.cart.remove', $item) }}"
                                        class="ajax-cart-remove text-red-600 hover:underline font-medium text-sm">
                                    Remove
                                </button>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="font-bold text-lg">₨{{ number_format($item->menuItem->price * $item->quantity, 0) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div>
                <div class="bg-white rounded-xl border border-slate-200 p-6 sticky top-24">
                    <h2 class="font-bold text-lg mb-4">Order Summary</h2>

                    <div class="space-y-3 mb-4 pb-4 border-b border-slate-100">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Subtotal</span>
                            <span class="font-medium">₨{{ number_format($subtotal, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Delivery Fee</span>
                            <span class="font-medium">₨{{ number_format($deliveryFee, 0) }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between mb-6">
                        <span class="font-bold">Total</span>
                        <span class="text-orange-600 font-extrabold text-xl">₨{{ number_format($total, 0) }}</span>
                    </div>

                    <a href="{{ route('orders.checkout') }}"
                       class="block text-center w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-orange-500/30">
                        Proceed to Checkout →
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl border p-16 text-center">
            <div class="text-6xl mb-4">🛒</div>
            <p class="text-slate-400 text-lg mb-4">Your cart is empty</p>
            <a href="{{ route('menu.index') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold">Browse Menu</a>
        </div>
    @endif
</div>

<script>
    // Quantity Update (AJAX)
    document.querySelectorAll('.ajax-cart-qty').forEach(input => {
        input.addEventListener('change', function() {
            const url = this.dataset.url;
            const quantity = this.value;

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.count);
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 500);
                }
            });
        });
    });

    // Remove (AJAX)
    document.querySelectorAll('.ajax-cart-remove').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!confirm('Remove this item?')) return;
            const url = this.dataset.url;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.count);
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 500);
                }
            });
        });
    });

    function updateCartCount(count) {
        const badge = document.getElementById('cart-count-badge');
        if (badge) {
            badge.textContent = count;
            if (count > 0) badge.classList.remove('hidden');
            else badge.classList.add('hidden');
        }
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-xl shadow-2xl text-white font-semibold ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2500);
    }
</script>

</body>
</html>