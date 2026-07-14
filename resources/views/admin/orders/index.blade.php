@extends('admin.layout')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Daftar Pesanan Masuk</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-4 text-xs font-bold text-gray-500 uppercase">No. Invoice</th>
                    <th class="p-4 text-xs font-bold text-gray-500 uppercase">Pelanggan</th>
                    <th class="p-4 text-xs font-bold text-gray-500 uppercase">Total Harga</th>
                    <th class="p-4 text-xs font-bold text-gray-500 uppercase">Bukti Bayar</th>
                    <th class="p-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="p-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <div class="mb-4">
                    <a href="{{ route('admin.orders.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-bold transition">
                        PDF Download Laporan
                    </a>
                </div>
                @forelse($orders as $order)
                <tr>
                    <td class="p-4 font-mono font-bold text-green-700">{{ $order->order_number }}</td>
                    <td class="p-4">
                        <div class="text-sm font-bold text-gray-800">{{ $order->customer_name }}</div>
                        <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                    </td>
                    <td class="p-4 font-bold text-gray-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                   <td class="px-6 py-4">
                        @if($order->payment_proof)
                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-blue-600 underline">
                                Lihat Bukti
                            </a>
                        @else
                            <span class="text-red-500 italic">Belum Upload</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @php
                            $colors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'paid' => 'bg-green-100 text-green-700',
                                'shipped' => 'bg-blue-100 text-blue-700',
                                'completed' => 'bg-gray-100 text-gray-700'
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colors[$order->status] ?? 'bg-gray-100' }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">
                            {{-- Form Update Status --}}
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="inline-flex gap-1">
                                @csrf
                                @method('PUT')
                                <select name="status" class="text-xs border rounded p-1 outline-none focus:ring-1 focus:ring-green-500">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Konfirmasi Bayar</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <button type="submit" class="bg-green-600 text-white px-2 py-1 rounded text-xs hover:bg-green-700">Update</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-12 text-center text-gray-400 italic">Belum ada pesanan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection