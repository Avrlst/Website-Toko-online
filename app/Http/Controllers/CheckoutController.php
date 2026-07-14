<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart');

        if (!$cart || count($cart) === 0) {
            return redirect('/')->with('error', 'Keranjang kosong');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = session('cart');
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'order_number' => 'ORD-' . time(),
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'customer_address' => $request->address,
            'total_price' => $total,
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect('/')->with('success', 'Pesanan berhasil dibuat');
    }//
}
