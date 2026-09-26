<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — FoodHub</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-slate-800 text-slate-300 fixed h-screen overflow-y-auto flex flex-col">
        <div class="px-6 py-5 border-b border-slate-700">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-extrabold text-white flex items-center gap-2">
                <span class="bg-orange-500 px-2 py-1 rounded text-sm">F</span> FoodHub
            </a>
            <p class="text-xs text-slate-400 mt-1">Admin Panel</p>
        </div>

        <nav class="py-4 flex-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-slate-700 hover:text-white transition
                      {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white border-l-4 border-white' : '' }}">
                📊 Dashboard
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-slate-700 hover:text-white transition
                      {{ request()->routeIs('admin.categories.*') ? 'bg-orange-500 text-white border-l-4 border-white' : '' }}">
                📂 Categories
            </a>
            <a href="{{ route('admin.menu-items.index') }}"
               class="flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-slate-700 hover:text-white transition
                      {{ request()->routeIs('admin.menu-items.*') ? 'bg-orange-500 text-white border-l-4 border-white' : '' }}">
                🍽️ Menu Items
            </a>
            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-slate-700 hover:text-white transition
                      {{ request()->routeIs('admin.orders.*') ? 'bg-orange-500 text-white border-l-4 border-white' : '' }}">
                📦 Orders
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-slate-700 hover:text-white transition
                      {{ request()->routeIs('admin.users.*') ? 'bg-orange-500 text-white border-l-4 border-white' : '' }}">
                👥 Users
            </a>
        </nav>

        <div class="px-6 py-4 border-t border-slate-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-400 hover:text-red-300 font-medium">
                    🚪 Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="ml-64 flex-1">

        {{-- TOPBAR --}}
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-40">
            <h1 class="text-xl font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
            <div class="flex items-center gap-5">
                <span class="text-xl cursor-pointer">🔔</span>
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="p-8">
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

            @yield('content')
        </div>

    </main>
</div>

@stack('scripts')
</body>
</html>