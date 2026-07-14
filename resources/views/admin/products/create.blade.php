@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Produk Baru</h1>
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:underline"> Kembali</a>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-xl p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama Produk --}}
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="name" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                    placeholder="Contoh: Janda Bolong Monstera">
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="category_id" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Harga --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                <input type="number" name="price" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                    placeholder="50000">
            </div>

            {{-- Stok --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                <input type="number" name="stock" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                    placeholder="10">
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Produk</label>
                <input type="file" name="image" required 
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            </div>

            {{-- Deskripsi --}}
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                <textarea name="description" rows="4" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                    placeholder="Jelaskan detail produk di sini..."></textarea>
            </div>

            {{-- Perawatan --}}
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cara Perawatan (Opsional)</label>
                <textarea name="care" rows="3" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                    placeholder="Contoh: Siram 2 kali sehari..."></textarea>
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" 
                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition duration-200">
                Simpan Produk
            </button>
        </div>
    </form>
</div>
@endsection