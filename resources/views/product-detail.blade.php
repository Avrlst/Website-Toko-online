@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row">
            
            {{-- Gambar Produk --}}
            <div class="md:w-1/2">
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-[500px] object-cover">
            </div>

            {{-- Informasi Produk --}}
            <div class="md:w-1/2 p-8 md:p-12">
                <span class="text-green-600 font-semibold uppercase tracking-wider text-sm">
                    {{ $product->category->name }}
                </span>
                <h1 class="text-4xl font-bold text-gray-800 mt-2 mb-4">{{ $product->name }}</h1>
                
                <p class="text-3xl font-bold text-gray-900 mb-6">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <div class="space-y-6">
                    {{-- Deskripsi --}}
                    <div>
                        <h3 class="font-bold text-gray-700 mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    {{-- Cara Perawatan --}}
                    @if($product->care)
                    <div class="bg-green-50 p-4 rounded-2xl border border-green-100">
                        <h3 class="font-bold text-green-800 mb-2 flex items-center">
                            🌿 Tips Perawatan
                        </h3>
                        <p class="text-green-700 text-sm italic">{{ $product->care }}</p>
                    </div>
                    @endif

                    {{-- Stok --}}
                    <div class="flex items-center gap-4">
                        <span class="text-gray-500 italic">Tersedia: <b>{{ $product->stock }}</b> unit</span>
                        @if($product->stock > 0)
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-bold">In Stock</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs rounded-full font-bold">Habis</span>
                        @endif
                    </div>

                    {{-- Tombol Beli --}}
                    {{-- Ganti link lama dengan form ini --}}
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf {{-- WAJIB: Tanpa ini akan error 419 --}}
                    
                    <div class="flex items-center gap-4 mt-6">
                        {{-- Input jumlah barang --}}
                        <input type="number" name="quantity" value="1" min="1" 
                            class="w-20 p-3 border rounded-xl outline-none focus:ring-2 focus:ring-green-500">
                        
                        {{-- Tombol Submit --}}
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg shadow-green-100">
                            🛒 Tambah ke Keranjang
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection