<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodHub — Order Delicious Food Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

{{-- NAVBAR --}}
<nav class="sticky top-0 z-50 bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <a href="{{ route('home.page') }}" class="flex items-center gap-2">
            <span class="bg-orange-500 text-white w-9 h-9 rounded-lg flex items-center justify-center font-extrabold text-lg">F</span>
            <span class="text-xl font-extrabold text-slate-800">FoodHub</span>
        </a>

        <ul class="hidden md:flex gap-6 list-none">
            <li><a href="{{ route('home.page') }}" class="text-orange-600 font-semibold text-sm">Home</a></li>
            <li><a href="{{ route('menu.index') }}" class="text-slate-600 hover:text-orange-600 font-medium text-sm">Menu</a></li>
            @auth
                <li><a href="{{ route('orders.my') }}" class="text-slate-600 hover:text-orange-600 font-medium text-sm">My Orders</a></li>
            @endauth
        </ul>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('cart.index') }}" class="relative p-2 hover:bg-slate-100 rounded-lg">
                    🛒
                    @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">{{ $cartCount }}</span>
                    @endif
                </a>
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-orange-600 hover:text-orange-700 px-3 py-2">Admin</a>
                @endif
                <span class="hidden md:block text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-slate-500 hover:text-red-600">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-orange-600 px-3 py-2">Login</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>

{{-- AJAX Cart Script --}}
<script>
    // Add to Cart (AJAX)
    document.querySelectorAll('.ajax-add-to-cart').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const itemId = this.dataset.itemId;
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
                    // Cart count update
                    updateCartCount(data.count);
                    // Toast message
                    showToast(data.message, 'success');
                }
            })
            .catch(err => {
                showToast('Something went wrong!', 'error');
            });
        });
    });

    function updateCartCount(count) {
        const badge = document.getElementById('cart-count-badge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-xl shadow-2xl text-white font-semibold transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.transform = 'translateX(400px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }
</script>

{{-- HERO --}}
<section class="bg-gradient-to-br from-orange-500 to-red-600 text-white py-16 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Order Delicious Food Online</h1>
        <p class="text-white/90 text-lg mb-8">Fresh, fast, and delivered to your doorstep</p>
        <form action="{{ route('menu.index') }}" method="GET" class="flex bg-white rounded-xl p-1.5 shadow-2xl max-w-xl mx-auto">
            <input type="text" name="search" placeholder="🔍  Search for dishes..."
                   class="flex-1 border-none outline-none px-4 py-3 text-slate-800 rounded-lg">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold">Search</button>
        </form>
    </div>
</section>

{{-- CATEGORIES --}}
<div class="max-w-6xl mx-auto px-4 pt-8 flex gap-3 flex-wrap justify-center">
    <a href="{{ route('menu.index') }}" class="px-5 py-2 rounded-full text-sm font-medium bg-orange-500 text-white">All</a>
    @foreach($categories as $category)
        <a href="{{ route('menu.index', ['category' => $category->slug]) }}"
           class="px-5 py-2 rounded-full text-sm font-medium bg-white text-slate-600 border border-slate-200 hover:border-orange-500 hover:text-orange-600">
            {{ $category->name }}
        </a>
    @endforeach
</div>

{{-- FEATURED --}}
<div class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">🔥 Featured Items</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($featuredItems as $item)
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-xl transition">
                <a href="{{ route('menu.show', $item->slug) }}">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-44 object-cover">
                    @else
                        <div class="w-full h-44 bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white text-5xl">🍕</div>
                    @endif
                </a>
                <div class="p-5">
                    <span class="inline-block bg-orange-100 text-orange-700 px-3 py-1 rounded text-xs font-bold uppercase mb-2">
                        {{ $item->category->name ?? 'Food' }}
                    </span>
                    <a href="{{ route('menu.show', $item->slug) }}">
                        <h3 class="font-bold text-lg mb-1 hover:text-orange-600">{{ $item->name }}</h3>
                    </a>
                    <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $item->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-extrabold text-orange-600">₨{{ number_format($item->price, 0) }}</span>
                        @auth
                            <button type="button"
        data-item-id="{{ $item->id }}"
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
        @empty
            <div class="col-span-full bg-white rounded-xl border p-16 text-center">
                <p class="text-slate-400 text-lg">No featured items yet.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- ALL ITEMS --}}
<div class="max-w-6xl mx-auto px-4 pb-12">
    <h2 class="text-2xl font-bold mb-6">🍽️ All Menu Items</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($menuItems as $item)
            <div class="bg-white rounded-xl border border-slate-200 p-4 flex gap-4 hover:shadow-lg transition">
                <a href="{{ route('menu.show', $item->slug) }}">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-24 h-24 object-cover rounded-lg">
                    @else
                        <div class="w-24 h-24 bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white text-3xl rounded-lg">🍔</div>
                    @endif
                </a>
                <div class="flex-1">
                    <a href="{{ route('menu.show', $item->slug) }}">
                        <h3 class="font-bold mb-1 hover:text-orange-600">{{ $item->name }}</h3>
                    </a>
                    <p class="text-xs text-slate-500 mb-2">{{ $item->category->name ?? '' }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-extrabold text-orange-600">₨{{ number_format($item->price, 0) }}</span>
                        @auth
                            <form action="{{ route('cart.add', $item) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white w-8 h-8 rounded-lg font-bold">+</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="bg-orange-500 text-white w-8 h-8 rounded-lg font-bold flex items-center justify-center">+</a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- FOOTER --}}
<footer class="bg-slate-800 text-slate-400 py-10 mt-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <div class="flex items-center justify-center gap-2 mb-4">
            <span class="bg-orange-500 text-white w-8 h-8 rounded-lg flex items-center justify-center font-extrabold">F</span>
            <span class="text-lg font-bold text-white">FoodHub</span>
        </div>
        <p class="text-xs">© 2026 FoodHub. All rights reserved.</p>
    </div>
</footer>

</body>
</html>