@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan #{{ $order->order_number }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:underline"> Kembali</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Sisi Kiri: Informasi Pelanggan & Item --}}
        <div class="md:col-span-2 space-y-6">
            {{-- Info Pelanggan --}}
            <div class="bg-white p-6 shadow-sm rounded-xl">
                <h3 class="font-bold border-b pb-2 mb-4">Informasi Pengiriman</h3>
                <p class="text-gray-800"><strong>Nama:</strong> {{ $order->customer_name }}</p>
                <p class="text-gray-800"><strong>HP:</strong> {{ $order->customer_phone }}</p>
                <p class="text-gray-800"><strong>Alamat:</strong> {{ $order->customer_address }}</p>
            </div>

            {{-- Daftar Produk --}}
            <div class="bg-white p-6 shadow-sm rounded-xl">
                <h3 class="font-bold border-b pb-2 mb-4">Item yang Dibeli</h3>
                <table class="w-full">
                    @foreach($order->items as $item)
                    <tr class="border-b last:border-0">
                        <td class="py-3">
                            <span class="font-medium text-gray-800">{{ $item->product->name }}</span><br>
                            <span class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price) }}</span>
                        </td>
                        <td class="py-3 text-right font-bold text-gray-800">
                            Rp {{ number_format($item->quantity * $item->price) }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="pt-4 font-bold text-lg">Total Bayar</td>
                        <td class="pt-4 text-right font-bold text-lg text-green-600">
                            Rp {{ number_format($order->total_price) }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Sisi Kanan: Update Status & Bukti Kirim --}}
        <div class="space-y-6">
            <div class="bg-white p-6 shadow-sm rounded-xl border-t-4 border-green-600">
                <h3 class="font-bold mb-4">Update Status Pesanan</h3>
                
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg focus:ring-green-500">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim (Shipped)</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Bukti Pengiriman (Resi/Foto)</label>
                        <input type="file" name="shipping_proof" class="text-xs w-full mb-2">
                        @if($order->shipping_proof)
                            <p class="text-[10px] text-gray-500 mb-1 font-bold">Bukti saat ini:</p>
                            <img src="{{ asset('storage/' . $order->shipping_proof) }}" class="rounded shadow-sm max-h-40 mx-auto">
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 rounded-lg hover:bg-green-700 transition">
                        Update Pesanan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection