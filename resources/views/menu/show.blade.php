<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item->name }} — FoodHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

@include('partials.navbar')

<div class="max-w-5xl mx-auto px-4 py-8">

    <a href="{{ route('menu.index') }}" class="text-orange-600 font-medium text-sm">← Back to Menu</a>

    <div class="grid md:grid-cols-2 gap-8 mt-6">
        {{-- Image --}}
        <div>
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="w-full rounded-2xl shadow-lg">
            @else
                <div class="w-full h-96 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center text-white text-8xl">🍽️</div>
            @endif
        </div>

        {{-- Details --}}
        <div>
            <span class="inline-block bg-orange-100 text-orange-700 px-3 py-1 rounded text-xs font-bold uppercase mb-3">
                {{ $item->category->name ?? 'Food' }}
            </span>

            <h1 class="text-3xl font-extrabold mb-3">{{ $item->name }}</h1>

            <p class="text-3xl font-extrabold text-orange-600 mb-4">₨{{ number_format($item->price, 0) }}</p>

            <p class="text-slate-600 mb-6 leading-relaxed">{{ $item->description }}</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-4 text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @auth
                <form action="{{ route('cart.add', $item) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold mb-2">Quantity</label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="decrementQty()" class="w-10 h-10 bg-slate-200 rounded-lg font-bold text-xl">−</button>
                            <input type="number" name="quantity" id="qty" value="1" min="1" max="20"
                                   class="w-20 text-center border border-slate-300 rounded-lg py-2 font-semibold">
                            <button type="button" onclick="incrementQty()" class="w-10 h-10 bg-slate-200 rounded-lg font-bold text-xl">+</button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-orange-500/30">
                        🛒 Add to Cart
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-center w-full bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-orange-500/30">
                    Login to Order
                </a>
            @endauth
        </div>
    </div>

    {{-- Related Items --}}
    @if($relatedItems->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-6">You might also like</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedItems as $related)
                    <a href="{{ route('menu.show', $related->slug) }}" class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg transition">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-32 object-cover">
                        @else
                            <div class="w-full h-32 bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white text-4xl">🍽️</div>
                        @endif
                        <div class="p-3">
                            <h3 class="font-semibold text-sm mb-1">{{ Str::limit($related->name, 25) }}</h3>
                            <p class="text-orange-600 font-bold text-sm">₨{{ number_format($related->price, 0) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    function incrementQty() {
        const input = document.getElementById('qty');
        if (parseInt(input.value) < 20) input.value = parseInt(input.value) + 1;
    }
    function decrementQty() {
        const input = document.getElementById('qty');
        if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    }
</script>

</body>
</html>