@extends('admin.layout')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    {{-- Kolom Kiri: Form Upload --}}
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Tambah Slide Baru</h2>
            
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul (Opsional)</label>
                    <input type="text" name="title" class="w-full px-4 py-2 border rounded-xl outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sub-judul (Opsional)</label>
                    <input type="text" name="subtitle" class="w-full px-4 py-2 border rounded-xl outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="order" value="0" class="w-full px-4 py-2 border rounded-xl outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Banner</label>
                    <input type="file" name="image" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-100">
                    Unggah Slide
                </button>
            </form>
        </div>
    </div>

    {{-- Kolom Kanan: Daftar Slide --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Preview</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase">Info</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sliders as $slide)
                    <tr>
                        <td class="p-4 w-48">
                            <img src="{{ asset('storage/' . $slide->image) }}" class="w-full h-24 object-cover rounded-lg shadow-sm">
                        </td>
                        <td class="p-4">
                            <p class="font-bold text-gray-800">{{ $slide->title ?? 'Tanpa Judul' }}</p>
                            <p class="text-xs text-gray-500">Urutan: {{ $slide->order }}</p>
                        </td>
                        <td class="p-4 text-center">
                            <form action="{{ route('admin.sliders.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('Hapus slide ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-12 text-center text-gray-400 italic">Belum ada slide carousel.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection