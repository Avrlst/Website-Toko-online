<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth; // Penting untuk menghilangkan error undefined
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // Tambahkan ini

class CartController extends Controller
{
    /**
     * Menampilkan isi keranjang dari database
     */
    public function index()
    {
        // Mengambil data keranjang milik user yang login beserta data produknya
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    /**
     * Menambah produk ke keranjang (Database Mode)
     */
    public function addToCart(Request $request, $id)
{

    if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }
    // Ambil jumlah dari input form. Jika tidak ada, gunakan default 1.
    // Pastikan 'quantity' di sini sama dengan 'name' di input HTML tadi.
    $quantity = $request->input('quantity', 1);

    $userId = Auth::id();

    // Cari apakah produk ini sudah ada di keranjang user
    $cartItem = \App\Models\Cart::where('user_id', $userId)
                                ->where('product_id', $id)
                                ->first();

    if ($cartItem) {
        // Jika sudah ada, tambahkan jumlah yang baru ke jumlah yang lama
        $cartItem->update([
            'quantity' => $cartItem->quantity + $quantity
        ]);
    } else {
        // Jika belum ada, buat baru dengan jumlah sesuai input ($quantity)
        \App\Models\Cart::create([
            'user_id' => $userId,
            'product_id' => $id,
            'quantity' => $quantity // <--- PASTIKAN INI VARIABEL $quantity
        ]);
    }

    return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan!');
}   

    /**
     * Menghapus item dari keranjang
     */
    public function remove($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        
        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang');
    }
}