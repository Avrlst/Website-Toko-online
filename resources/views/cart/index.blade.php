@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-green-800 mb-8">Keranjang Belanja</h1>

    {{-- PERBAIKAN: Cek variabel $cartItems dari database, bukan session --}}
    @if(isset($cartItems) && $cartItems->count() > 0)
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">Produk</th>
                        <th class="px-6 py-4 text-center">Harga</th>
                        <th class="px-6 py-4 text-center">Jumlah</th>
                        <th class="px-6 py-4 text-right">Subtotal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php $total = 0 @endphp
                    @foreach($cartItems as $item)
                        @php 
                            $subtotal = $item->product->price * $item->quantity;
                            $total += $subtotal;
                        @endphp
                        <tr class="hover:bg-green-50 transition">
                            <td class="px-6 py-4 flex items-center gap-4">
                                {{-- Mengambil data melalui relasi product --}}
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-16 h-16 object-cover rounded-lg">
                                <span class="font-semibold text-gray-800">{{ $item->product->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                Rp {{ number_format($item->product->price) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-gray-100 px-3 py-1 rounded-full font-bold">{{ $item->quantity }}</span>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-green-700">
                                Rp {{ number_format($subtotal) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{-- Ganti route remove agar sesuai dengan ID di tabel carts --}}
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-6 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-2xl font-bold text-gray-800">
                    Total: <span class="text-green-600">Rp {{ number_format($total) }}</span>
                </div>
                <div class="flex gap-4">
                    <a href="{{ url('/') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-300 transition">
                        Lanjut Belanja
                    </a>
                    <a href="{{ route('checkout.index') }}" class="bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700 shadow-lg shadow-green-200 transition">
                        Checkout Sekarang
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-dashed">
            <p class="text-gray-400 mb-4">Keranjang belanja Anda masih kosong.</p>
            <a href="{{ url('/') }}" class="inline-block bg-green-600 text-white px-8 py-3 rounded-xl font-bold">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection