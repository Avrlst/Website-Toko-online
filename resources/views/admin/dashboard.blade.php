@extends('admin.layout')

@section('content')
<h1 class="text-2xl font-bold mb-6 text-gray-800">Dashboard Statistik</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card border-l-4 border-green-500">
        <p class="text-sm text-gray-500 font-medium">Total Produk</p>
        <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
    </div>
    <div class="card border-l-4 border-blue-500">
        <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
        <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
    </div>
    <div class="card border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500 font-medium">Pendapatan</p>
        <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalRevenue) }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-4 border-b border-gray-100">
        <h2 class="font-bold text-gray-700">Pesanan Terbaru</h2>
    </div>
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50">
            <tr>
                <th class="p-4 text-xs font-bold text-gray-500 uppercase">Order ID</th>
                <th class="p-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                <th class="p-4 text-xs font-bold text-gray-500 uppercase">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($latestOrders as $order)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4 font-medium text-green-700">#{{ $order->order_number }}</td>
                <td class="p-4 uppercase text-xs font-bold">
                    <span class="{{ $order->status == 'pending' ? 'text-yellow-600' : 'text-green-600' }}">
                        {{ $order->status }}
                    </span>
                </td>
                <td class="p-4 text-gray-700 font-semibold">Rp {{ number_format($order->total_price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection