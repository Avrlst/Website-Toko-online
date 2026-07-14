@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12 bg-white p-8 rounded-2xl shadow-lg border border-green-100">
    <h2 class="text-2xl font-bold text-green-800 mb-6 text-center">Buat Akun Baru</h2>
    
    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" class="w-full p-3 border rounded-xl" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="w-full p-3 border rounded-xl" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" class="w-full p-3 border rounded-xl" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full p-3 border rounded-xl" required>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-xl font-bold hover:bg-green-700 transition">Daftar Akun</button>
    </form>
</div>
@endsection