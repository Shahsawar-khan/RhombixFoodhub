<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu — FoodHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

@include('partials.navbar')

{{-- HERO --}}
<div class="bg-gradient-to-br from-orange-500 to-red-600 text-white py-12 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-4">Our Menu</h1>
        <form action="{{ route('menu.index') }}" method="GET" class="flex bg-white rounded-xl p-1.5 shadow-2xl max-w-xl mx-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍  Search dishes..."
                   class="flex-1 border-none outline-none px-4 py-3 text-slate-800 rounded-lg">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold">Search</button>
        </form>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- CATEGORY FILTER --}}
    <div class="flex gap-3 flex-wrap mb-8">
        <a href="{{ route('menu.index') }}"
           class="px-5 py-2 rounded-full text-sm font-medium border transition
                  {{ !request('category') ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-slate-600 border-slate-200 hover:border-orange-500' }}">
            All
        </a>
        @foreach($categories as $category)
            <a href="{{ route('menu.index', ['category' => $category->slug]) }}"
               class="px-5 py-2 rounded-full text-sm font-medium border transition
                      {{ request('category') === $category->slug ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-slate-600 border-slate-200 hover:border-orange-500' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    {{-- SEARCH INFO --}}
    @if(request('search'))
        <p class="mb-6 text-slate-600">
            Search results for: <strong>"{{ request('search') }}"</strong>
            <a href="{{ route('menu.index') }}" class="text-orange-600 text-sm ml-2 hover:underline">Clear</a>
        </p>
    @endif

    {{-- MENU ITEMS --}}
    @if($menuItems->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($menuItems as $item)
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-xl transition">
                    <a href="{{ route('menu.show', $item->slug) }}">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-44 object-cover">
                        @else
                            <div class="w-full h-44 bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white text-5xl">🍽️</div>
                        @endif
                    </a>
                    <div class="p-5">
                        <span class="inline-block bg-orange-100 text-orange-700 px-3 py-1 rounded text-xs font-bold uppercase mb-2">
                            {{ $item->category->name ?? 'Food' }}
                        </span>
                        <a href="{{ route('menu.show', $item->slug) }}">
                            <h3 class="font-bold text-lg mb-1 hover:text-orange-600">{{ $item->name }}</h3>
                        </a>
                        <p class="text-slate-500 text-sm mb-4">{{ Str::limit($item->description, 80) }}</p>

                        <div class="flex justify-between items-center">
                            <span class="text-xl font-extrabold text-orange-600">₨{{ number_format($item->price, 0) }}</span>

                            @auth
                                <button type="button"
                                        data-url="{{ route('api.cart.add', $item) }}"
                                        class="ajax-add-to-cart bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold text-sm transition">
                                    Add to Cart
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold text-sm">
                                    Add to Cart
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">{{ $menuItems->links() }}</div>
    @else
        <div class="bg-white rounded-xl border p-16 text-center">
            <p class="text-slate-400 text-lg">No items found.</p>
            <a href="{{ route('menu.index') }}" class="text-orange-600 font-semibold mt-3 inline-block">View all items</a>
        </div>
    @endif

</div>

{{-- AJAX CART SCRIPT --}}
<script>
    document.querySelectorAll('.ajax-add-to-cart').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.dataset.url;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ quantity: 1 })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.count);
                    showToast(data.message, 'success');
                }
            })
            .catch(() => showToast('Something went wrong!', 'error'));
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