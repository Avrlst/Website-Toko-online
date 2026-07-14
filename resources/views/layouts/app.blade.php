<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Toko Tanaman</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

</head>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: { delay: 4000 },
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    });
</script>

<body class="bg-green-50 text-gray-800">
<nav class="bg-white shadow-md sticky top-0 z-50 font-sans">
    <div class="container mx-auto px-4 h-16 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-green-700">GrowGarden</a>

        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-green-600 font-medium">Beranda</a>

            <div class="relative group">
                <button class="flex items-center text-gray-600 hover:text-green-600 font-medium gap-1 focus:outline-none">
                    Kategori
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="absolute hidden group-hover:block w-48 bg-white shadow-xl rounded-xl border border-gray-100 py-2 mt-0">
                    @php $nav_categories = \App\Models\Category::all(); @endphp
                    @foreach($nav_categories as $cat)
                        <a href="{{ url('/kategori/'.$cat->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-6">
            <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-green-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); @endphp
                @if($cartCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $cartCount }}</span>
                @endif
            </a>

            @guest
                <a href="{{ route('login') }}" class="text-gray-600 font-medium">Masuk</a>
                <a href="{{ route('register') }}" class="bg-green-600 text-white px-5 py-2 rounded-lg font-bold">Daftar</a>
            @else
                <div class="relative group">
                    <button class="flex items-center space-x-2 focus:outline-none">
                        <div class="w-8 h-8 bg-green-100 text-green-700 rounded-full flex items-center justify-center font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-gray-700 font-medium hidden md:block">{{ auth()->user()->name }}</span>
                    </button>
                    <div class="absolute right-0 hidden group-hover:block w-56 bg-white shadow-2xl rounded-2xl border border-gray-100 py-2 mt-0">
                        @if(auth()->user()->is_admin == 1)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm font-bold text-orange-600 hover:bg-orange-50">🛠 Admin Panel</a>
                            <hr class="my-1">
                        @endif
                        <a href="{{ route('orders.history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Riwayat Pesanan</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>
@if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg mb-6 text-center font-bold">
        {{ session('success') }}
    </div>
@endif

<main class="max-w-7xl mx-auto px-6 py-8">
    @yield('content')
    @if(session('success'))
    <div id="alert" class="max-w-7xl mx-auto px-6 mt-4">
        <div class="bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg flex justify-between items-center animate-fade-in">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('alert').remove()" class="text-white hover:text-green-200">✕</button>
        </div>
    </div>
@endif
</main>

<footer class="bg-green-600 text-white text-center py-4">
    © 2026 Grow A Garden
</footer>

</body>
</html>
