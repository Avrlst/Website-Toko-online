@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12 bg-white p-8 rounded-2xl shadow-lg border border-green-100">
    <h2 class="text-2xl font-bold text-green-800 mb-6 text-center">Masuk ke GrowGarden</h2>
    
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="w-full p-3 border rounded-xl focus:ring-green-500 focus:border-green-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" class="w-full p-3 border rounded-xl focus:ring-green-500 focus:border-green-500" required>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-xl font-bold hover:bg-green-700 transition">Login</button>
    </form>
    
    <p class="mt-6 text-center text-sm text-gray-600">
        Belum punya akun? <a href="{{ route('register') }}" class="text-green-600 font-bold hover:underline">Daftar Sekarang</a>
    </p>
</div>
@endsection