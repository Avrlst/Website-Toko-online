<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - GrowGarden</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .card { @apply bg-white p-6 rounded-xl shadow-sm border border-gray-100; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-green-800 text-white flex-shrink-0">
        <div class="p-6">
            <h1 class="text-xl font-bold italic">GrowGarden Admin</h1>
        </div>
        <nav class="mt-4 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition hover:bg-green-700 {{ request()->routeIs('admin.dashboard') ? 'bg-green-700' : '' }}">
                📊 Dashboard
            </a>
            <a href="{{ route('admin.categories.index') }}" class="block py-2.5 px-4 rounded transition hover:bg-green-700 {{ request()->routeIs('admin.categories.*') ? 'bg-green-700' : '' }}">
                📁 Kategori
            </a>
            <a href="{{ route('admin.products.index') }}" class="block py-2.5 px-4 rounded transition hover:bg-green-700 {{ request()->routeIs('admin.products.*') ? 'bg-green-700' : '' }}">
                🌿 Produk
            </a>
            <a href="{{ route('admin.orders.index') }}" class="block py-2.5 px-4 rounded transition hover:bg-green-700 {{ request()->routeIs('admin.orders.*') ? 'bg-green-700' : '' }}">
                🛒 Pesanan
            </a>
            <a href="{{ route('admin.sliders.index') }}" class="block py-2.5 px-4 rounded transition hover:bg-green-700 {{ request()->routeIs('admin.sliders.*') ? 'bg-green-700' : '' }}">
                    🖼️ Carousel Slider
            </a>
            <hr class="border-green-700 my-4">
            <a href="{{ url('/') }}" class="block py-2.5 px-4 rounded transition hover:bg-green-700">
                🌐 Lihat Website
            </a>
        </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <span class="font-medium text-gray-600">Selamat Datang, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-red-600 font-bold hover:underline">Logout</button>
            </form>
        </header>

        <main class="p-8">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>