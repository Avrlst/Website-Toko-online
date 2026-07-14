@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Pesanan</h1>
            <p class="text-gray-500">Pantau status pembayaran dan pengiriman tanaman Anda</p>
        </div>
        <a href="{{ route('home') }}" class="text-green-600 font-semibold hover:underline">
            &larr; Lanjut Belanja
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white p-12 rounded-3xl shadow-sm text-center border border-gray-100">
            <div class="text-6xl mb-4">🛒</div>
            <h3 class="text-xl font-bold text-gray-800">Belum ada pesanan</h3>
            <p class="text-gray-500 mt-2">Anda belum pernah melakukan pemesanan tanaman.</p>
            <a href="{{ route('home') }}" class="inline-block mt-6 bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700 transition">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm uppercase">
                            <th class="px-6 py-4 font-bold">No. Invoice</th>
                            <th class="px-6 py-4 font-bold">Tanggal</th>
                            <th class="px-6 py-4 font-bold">Total</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold">Bukti TF</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-mono text-sm text-green-700 font-bold">
                                {{ $order->order_number }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800">
                                Rp {{ number_format($order->total_price) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($order->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                        Menunggu Konfirmasi
                                    </span>
                                @elseif($order->status == 'paid')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                        Sudah Dibayar
                                    </span>
                                @elseif($order->status == 'completed')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                        Selesai
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                        {{ $order->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                            {{-- KODE REVIEW DITARUH DI SINI --}}
                            @if($order->status == 'completed')
                                <button onclick="openReviewModal('{{ $order->id }}')" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">
                                    Beri Ulasan
                                </button>
                            @else
                                <span class="text-gray-400 text-xs italic">Belum bisa ulas</span>
                            @endif
                        </td>
                            <td class="px-6 py-4 text-sm">
                                @if($order->payment_proof)
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-green-600 hover:underline flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-red-400 italic text-xs">Tidak ada file</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
<div id="reviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Berikan Ulasan Anda</h3>
        
        <form action="{{ route('review.store') }}" method="POST">
            @csrf
            {{-- Input ID Produk akan diisi otomatis via JS --}}
            <input type="hidden" name="product_id" id="modal_product_id">
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Rating</label>
                <select name="rating" class="w-full border rounded-xl p-2.5 bg-gray-50 focus:ring-2 focus:ring-blue-500">
                    <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                    <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                    <option value="3">⭐⭐⭐ (Cukup)</option>
                    <option value="2">⭐⭐ (Buruk)</option>
                    <option value="1">⭐ (Sangat Buruk)</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Komentar</label>
                <textarea name="comment" rows="4" required class="w-full border rounded-xl p-3 bg-gray-50 focus:ring-2 focus:ring-blue-500" placeholder="Ceritakan pengalaman Anda belanja tanaman ini..."></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeReviewModal()" class="px-4 py-2 text-gray-500 font-semibold hover:text-gray-700">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-blue-700 shadow-lg">Kirim Ulasan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openReviewModal(orderId) {
        // Logikanya: Kita harus tahu produk mana yang diulas. 
        // Untuk simpelnya, kita set ID produk ke modal.
        document.getElementById('modal_product_id').value = orderId; 
        document.getElementById('reviewModal').classList.remove('hidden');
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
    }
</script>
@endsection