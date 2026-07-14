@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Produk</h1>

<a href="{{ route('admin.products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">
Tambah Produk
</a>

<table class="w-full mt-4 bg-white shadow rounded">
@foreach($products as $product)
<tr class="border-b">
<td class="p-2">{{ $product->name }}</td>
<td>{{ $product->category->name }}</td>
<td>Rp {{ number_format($product->price) }}</td>
<td class="p-2 flex gap-2">
    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:underline">Edit</a>
    
    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
    </form>
</td>
</tr>
@endforeach
</table>
@endsection
