@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kategori</h1>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-xl p-8">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            {{-- Nama Kategori --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Gambar (Kosongkan jika tidak diubah)</label>
                <input type="file" name="image" 
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700">
                
                <div class="mt-4">
                    <p class="text-xs text-gray-500 mb-2">Gambar saat ini:</p>
                    <img src="{{ asset('storage/' . $category->image) }}" class="h-24 w-24 object-cover rounded-lg border">
                </div>
            </div>
        </div>

        <div class="mt-8 flex gap-4">
            <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition">
                Update Kategori
            </button>
            <a href="{{ route('admin.categories.index') }}" class="flex-1 bg-gray-100 text-gray-700 text-center font-bold py-3 rounded-lg transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection