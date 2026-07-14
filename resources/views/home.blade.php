@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    /* Mengatur tinggi carousel agar terlihat jelas */
    .mySwiper {
        width: 100%;
        height: 500px;
        border-radius: 20px;
    }
    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* PERBAIKAN: dari object-cover menjadi object-fit */
    }
</style>

{{-- Carousel --}}
<section class="mb-12">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @forelse($sliders as $slide)
                <div class="swiper-slide relative">
                    <img src="{{ asset('storage/'.$slide->image) }}" alt="{{ $slide->title }}">
                    @if($slide->title || $slide->subtitle)
                        <div class="absolute inset-0 bg-black/30 flex flex-col justify-center px-12 text-white">
                            <h2 class="text-4xl font-bold">{{ $slide->title }}</h2>
                            <p class="text-xl mt-2">{{ $slide->subtitle }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="swiper-slide">
                    <img src="https://via.placeholder.com/1200x500?text=Belum+Ada+Slider" class="w-full h-full object-cover">
                </div>
            @endforelse
        </div>

        {{-- Navigasi (Harus di dalam div mySwiper agar posisinya benar) --}}
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next text-white"></div>
        <div class="swiper-button-prev text-white"></div>
    </div>
</section>

{{-- Kategori --}}
<h3 class="text-xl font-semibold mb-4 text-green-800">Kategori</h3>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    @foreach ($categories as $category)
        <a href="{{ url('/kategori/'.$category->slug) }}"
           class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 text-center">
            <img src="{{ asset('storage/'.$category->image) }}"
                 class="h-32 mx-auto mb-3 object-cover rounded w-full">
            <h4 class="font-semibold">{{ $category->name }}</h4>
        </a>
    @endforeach
</div>

{{-- Produk --}}
<h3 class="text-xl font-semibold mb-4 text-green-800">Produk Unggulan</h3>
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 italic">
    {{-- Di bagian loop produk home.blade.php --}}
@foreach ($products as $product)
    <div class="bg-white rounded-xl shadow p-4">
        {{-- Tambahkan Link di sini --}}
        <a href="{{ route('product.detail', $product->slug) }}">
            <img src="{{ asset('storage/'.$product->image) }}"
                 class="h-48 w-full object-cover rounded mb-3 hover:opacity-80 transition cursor-pointer">
        </a>
        <h4 class="font-semibold">{{ $product->name }}</h4>
        ...
    </div>
@endforeach
</div>
<section class="py-16 bg-green-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Apa Kata Mereka?</h2>
            <p class="text-gray-600 mt-2">Ulasan jujur dari pecinta tanaman yang telah berbelanja di GrowGarden</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($reviews as $review)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="text-yellow-400 mb-3 flex">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endif
                            @endfor
                        </div>
                        
                        <p class="text-gray-700 italic mb-4">"{{ Str::limit($review->comment, 100) }}"</p>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-gray-50">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800">{{ $review->user->name }}</h4>
                            <p class="text-[10px] text-green-600 font-semibold uppercase tracking-wider">Membeli: {{ $review->product->name }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    });
</script>

@endsection