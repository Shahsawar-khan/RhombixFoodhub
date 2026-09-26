<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — FoodHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .input-field { width: 100%; padding: 12px 16px; border: 1.5px solid #E2E8F0; border-radius: 10px; font-size: 15px; outline: none; }
        .input-field:focus { border-color: #F97316; box-shadow: 0 0 0 4px rgba(249,115,22,0.1); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

@include('partials.navbar')

<div class="max-w-6xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-extrabold mb-8">Checkout</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-6">❌ {{ session('error') }}</div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="grid md:grid-cols-3 gap-8">

            {{-- Delivery Info --}}
            <div class="md:col-span-2 space-y-6">

                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h2 class="font-bold text-lg mb-4">Delivery Information</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="input-field" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="input-field" placeholder="03XX-XXXXXXX" required>
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Delivery Address</label>
                            <textarea name="address" rows="3" class="input-field" placeholder="House #, Street, Area, City" required>{{ old('address') }}</textarea>
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Order Notes (optional)</label>
                            <textarea name="notes" rows="2" class="input-field" placeholder="Any special instructions...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h2 class="font-bold text-lg mb-4">Payment Method</h2>

                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-orange-500 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                            <input type="radio" name="payment_method" value="cod" checked class="text-orange-500">
                            <div class="flex-1">
                                <div class="font-semibold">💵 Cash on Delivery</div>
                                <div class="text-xs text-slate-500">Pay when your order arrives</div>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-orange-500 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                            <input type="radio" name="payment_method" value="easypaisa" class="text-orange-500">
                            <div class="flex-1">
                                <div class="font-semibold">📱 Easypaisa</div>
                                <div class="text-xs text-slate-500">Pay via Easypaisa mobile account</div>
                            </div>
                        </label>
                    </div>

                    @error('payment_method') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Order Summary --}}
            <div>
                <div class="bg-white rounded-xl border border-slate-200 p-6 sticky top-24">
                    <h2 class="font-bold text-lg mb-4">Order Summary</h2>

                    <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">{{ $item->menuItem->name }} × {{ $item->quantity }}</span>
                                <span class="font-medium">₨{{ number_format($item->menuItem->price * $item->quantity, 0) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-100 pt-4 space-y-3 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Subtotal</span>
                            <span class="font-medium">₨{{ number_format($subtotal, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Delivery Fee</span>
                            <span class="font-medium">₨{{ number_format($deliveryFee, 0) }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between mb-6 pt-4 border-t border-slate-100">
                        <span class="font-bold">Total</span>
                        <span class="text-orange-600 font-extrabold text-xl">₨{{ number_format($total, 0) }}</span>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-orange-500/30">
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>