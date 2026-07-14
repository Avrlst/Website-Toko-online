@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-green-800 mb-8 text-center">Informasi Pengiriman</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Form Alamat --}}
        <div class="md:col-span-2">
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data"ass="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap Penerima</label>
                    <input type="text" name="customer_name" required class="w-full border-gray-200 rounded-xl p-3 focus:ring-green-500" placeholder="Masukkan nama lengkap">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                    <input type="text" name="customer_phone" required class="w-full border-gray-200 rounded-xl p-3 focus:ring-green-500" placeholder="Contoh: 08123456789">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap Pengiriman</label>
                    <textarea name="customer_address" rows="4" required class="w-full border-gray-200 rounded-xl p-3 focus:ring-green-500" placeholder="Jalan, No. Rumah, Kecamatan, Kota"></textarea>
                </div>
                {{-- Tambahkan ini di dalam <form> sebelum tombol submit --}}
                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mb-6">
                    <label class="block text-sm font-bold text-blue-800 mb-2">Unggah Bukti Pembayaran (Transfer)</label>
                    <p class="text-xs text-blue-600 mb-3">*Silakan transfer ke Rekening BCA: 12345678 a/n GrowGarden</p>
                    <input type="file" name="payment_proof" required 
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>
                
                <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-700 transition shadow-lg">
                    Konfirmasi & Buat Pesanan
                </button>
            </form>
        </div>

        {{-- Ringkasan Pesanan (Mode Database) --}}
        <div class="md:col-span-1">
            <div class="bg-green-50 p-6 rounded-2xl sticky top-8 border border-green-100">
                <h3 class="font-bold text-green-800 mb-4 text-xl border-b border-green-200 pb-2">Ringkasan Pesanan</h3>
                <div class="space-y-4">
                    @php $total = 0 @endphp
                    {{-- PERBAIKAN: Looping menggunakan variabel dari database --}}
                    @foreach($cartItems as $item)
                        @php 
                            $subtotal = $item->product->price * $item->quantity;
                            $total += $subtotal;
                        @endphp
                        <div class="flex justify-between items-start gap-4">
                            <div class="text-sm">
                                <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                                <p class="text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->product->price) }}</p>
                            </div>
                            <span class="font-bold text-gray-800 text-sm">Rp {{ number_format($subtotal) }}</span>
                        </div>
                    @endforeach

                    <div class="border-t border-green-200 pt-4 flex justify-between items-center text-xl">
                        <span class="font-bold text-green-800">Total</span>
                        <span class="font-bold text-green-600">Rp {{ number_format($total) }}</span>
                    </div>
                </div>
                <p class="mt-6 text-xs text-green-700 leading-relaxed italic">
                    *Admin akan menghubungi Anda via WhatsApp setelah pesanan dibuat untuk proses pembayaran.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection