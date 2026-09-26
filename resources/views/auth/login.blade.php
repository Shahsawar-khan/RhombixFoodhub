<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — FoodHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .form-input {
            width: 100%; padding: 14px 16px 14px 46px; border: 1.5px solid #E2E8F0;
            border-radius: 12px; font-size: 15px; outline: none;
            transition: all 0.2s; background: #fff;
        }
        .form-input:focus { border-color: #F97316; box-shadow: 0 0 0 4px rgba(249,115,22,0.1); }
        .input-icon {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            color: #94A3B8; font-size: 18px;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 flex items-center justify-center p-4">

<div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

    {{-- LEFT SIDE — BRANDING --}}
    <div class="hidden md:flex flex-col justify-between bg-gradient-to-br from-orange-500 to-red-600 text-white p-12 relative overflow-hidden">

        {{-- Decorative circles --}}
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white/10 rounded-full"></div>

        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-12">
                <span class="bg-white text-orange-500 px-3 py-2 rounded-xl font-extrabold text-xl">F</span>
                <span class="text-2xl font-extrabold">FoodHub</span>
            </div>

            <h2 class="text-4xl font-extrabold leading-tight mb-6">
                Delicious Food<br>Delivered to Your Door
            </h2>

            <p class="text-white/90 text-lg leading-relaxed mb-10">
                Order your favorite meals from the best restaurants in town. Fast delivery, fresh food, and easy payments.
            </p>

            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">🍕</span>
                    <span class="font-medium">Wide variety of dishes</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">🚚</span>
                    <span class="font-medium">Fast delivery to your door</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">💳</span>
                    <span class="font-medium">COD & Easypaisa payments</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">⭐</span>
                    <span class="font-medium">Top-rated quality</span>
                </div>
            </div>
        </div>

        <p class="relative z-10 text-white/70 text-sm">
            © 2026 FoodHub. All rights reserved.
        </p>
    </div>

    {{-- RIGHT SIDE — FORM --}}
    <div class="p-8 md:p-12 flex flex-col justify-center">

        {{-- Mobile logo --}}
        <div class="md:hidden flex items-center gap-3 mb-8 justify-center">
            <span class="bg-orange-500 text-white px-3 py-2 rounded-xl font-extrabold text-lg">F</span>
            <span class="text-2xl font-extrabold text-slate-800">FoodHub</span>
        </div>

        {{-- Tabs --}}
        <div class="flex bg-slate-100 rounded-xl p-1 mb-8">
            <button id="tab-login" onclick="switchTab('login')"
                    class="flex-1 py-3 rounded-lg font-semibold text-sm transition-all bg-white shadow text-orange-600">
                Login
            </button>
            <button id="tab-register" onclick="switchTab('register')"
                    class="flex-1 py-3 rounded-lg font-semibold text-sm transition-all text-slate-500">
                Register
            </button>
        </div>

        {{-- LOGIN FORM --}}
        <div id="form-login">
            <h1 class="text-3xl font-extrabold mb-2 text-slate-800">Welcome Back 👋</h1>
            <p class="text-slate-500 mb-8">Login to continue ordering delicious food</p>

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div class="relative">
                    <span class="input-icon">📧</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-input" placeholder="Email address" required autofocus>
                </div>
                @error('email')
                    <p class="text-red-500 text-xs -mt-3">{{ $message }}</p>
                @enderror

                <div class="relative">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password"
                           class="form-input" placeholder="Password" required>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs -mt-3">{{ $message }}</p>
                @enderror

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded">
                        <span class="text-slate-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-orange-600 font-medium hover:underline text-xs">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white py-4 rounded-xl font-bold text-base shadow-lg shadow-orange-500/30 transition-all">
                    Login to FoodHub
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-slate-500">
                New to FoodHub?
                <button onclick="switchTab('register')" class="text-orange-600 font-semibold hover:underline">
                    Create an account
                </button>
            </p>
        </div>

        {{-- REGISTER FORM --}}
        <div id="form-register" class="hidden">
            <h1 class="text-3xl font-extrabold mb-2 text-slate-800">Create Account ✨</h1>
            <p class="text-slate-500 mb-8">Join FoodHub and start ordering today</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="relative">
                    <span class="input-icon">👤</span>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="form-input" placeholder="Full name" required>
                </div>
                @error('name')
                    <p class="text-red-500 text-xs -mt-2">{{ $message }}</p>
                @enderror

                <div class="relative">
                    <span class="input-icon">📧</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-input" placeholder="Email address" required>
                </div>
                @error('email')
                    <p class="text-red-500 text-xs -mt-2">{{ $message }}</p>
                @enderror

                <div class="relative">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password"
                           class="form-input" placeholder="Password (min 8 chars)" required>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs -mt-2">{{ $message }}</p>
                @enderror

                <div class="relative">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password_confirmation"
                           class="form-input" placeholder="Confirm password" required>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white py-4 rounded-xl font-bold text-base shadow-lg shadow-orange-500/30 transition-all mt-2">
                    Create My Account
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-slate-500">
                Already have an account?
                <button onclick="switchTab('login')" class="text-orange-600 font-semibold hover:underline">
                    Login here
                </button>
            </p>
        </div>

    </div>
</div>

<script>
    function switchTab(tab) {
        const loginForm = document.getElementById('form-login');
        const registerForm = document.getElementById('form-register');
        const loginTab = document.getElementById('tab-login');
        const registerTab = document.getElementById('tab-register');

        if (tab === 'login') {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            loginTab.classList.add('bg-white', 'shadow', 'text-orange-600');
            loginTab.classList.remove('text-slate-500');
            registerTab.classList.remove('bg-white', 'shadow', 'text-orange-600');
            registerTab.classList.add('text-slate-500');
        } else {
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            registerTab.classList.add('bg-white', 'shadow', 'text-orange-600');
            registerTab.classList.remove('text-slate-500');
            loginTab.classList.remove('bg-white', 'shadow', 'text-orange-600');
            loginTab.classList.add('text-slate-500');
        }
    }

    // Agar register form mein error hai toh auto-switch
    @if($errors->has('name') || $errors->has('password_confirmation'))
        switchTab('register');
    @endif
</script>

</body>
</html>