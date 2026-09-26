<nav class="sticky top-0 z-50 bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <a href="{{ route('home.page') }}" class="flex items-center gap-2">
            <span class="bg-orange-500 text-white w-9 h-9 rounded-lg flex items-center justify-center font-extrabold text-lg">F</span>
            <span class="text-xl font-extrabold text-slate-800">FoodHub</span>
        </a>

        <ul class="hidden md:flex gap-6 list-none">
            <li><a href="{{ route('home.page') }}" class="text-slate-600 hover:text-orange-600 font-medium text-sm">Home</a></li>
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
    <span id="cart-count-badge" class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold {{ $cartCount > 0 ? '' : 'hidden' }}">
        {{ $cartCount }}
    </span>
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