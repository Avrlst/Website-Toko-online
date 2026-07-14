@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-green-800 mb-6 italic">Kategori: {{ $category->name }}</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                {{-- Pastikan link menggunakan route detail produk --}}
                <a href="{{ route('product.detail', $product->slug) }}">
                    <img src="{{ asset('storage/'.$product->image) }}"
                         class="h-48 w-full object-cover rounded-lg mb-3 hover:opacity-80 transition">
                </a>
                
                <h4 class="font-semibold text-gray-800">{{ $product->name }}</h4>
                
                <p class="text-green-600 font-bold mt-1">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <div class="mt-auto pt-4">
                    <a href="{{ route('product.detail', $product->slug) }}" 
                       class="block text-center bg-green-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @endforeach {{-- Pastikan ini tertutup dengan benar --}}
    </div>

    {{-- Pesan jika produk kosong --}}
    @if($products->isEmpty())
        <div class="text-center py-20">
            <p class="text-gray-500 italic">Belum ada produk di kategori ini.</p>
        </div>
    @endif {{-- Pastikan @endif ini ada --}}
</div>
@endsection