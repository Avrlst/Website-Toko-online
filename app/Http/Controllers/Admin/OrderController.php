<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Tampilan untuk Admin melihat semua pesanan masuk
     */
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Fungsi Store (Proses Checkout oleh User)
     * Catatan: Jika ingin lebih rapi, pindahkan ini ke User/OrderController
     */
    public function store(Request $request)
    {
        $request->validate([
        'customer_name' => 'required',
        'customer_phone' => 'required',
        'customer_address' => 'required',
        ]);
        $userId = Auth::id(); 
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong!');
        }

        $request->validate([
            'customer_address' => 'required',
            'payment_proof' => 'required|image|max:2048'
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');

        // Hitung total harga
        $totalPrice = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        $imagePath = null;
        if ($request->hasFile('payment_proof')) {
            // Menyimpan file ke folder 'public/payments'
            $imagePath = $request->file('payment_proof')->store('payments', 'public');
        }

        // Simpan Order
        $order = Order::create([
            'order_number' => 'INV-' . strtoupper(Str::random(6)),
            'customer_name' => Auth::user()->name,
            'customer_phone' => $request->customer_phone ?? '00000000', 
            'customer_address' => $request->customer_address,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_proof' => $path
        ]);

        // Pindahkan ke OrderItems
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        

        // Kosongkan Cart
        Cart::where('user_id', $userId)->delete();

        return redirect()->route('home')->with('success', 'Pesanan Anda berhasil dikirim! Tunggu konfirmasi admin.');
    }

    public function generateReport()
{
    $orders = Order::where('status', 'completed')->get(); // Ambil hanya yang sudah selesai
    
    $pdf = Pdf::loadView('admin.orders.report_pdf', compact('orders'));
    return $pdf->download('laporan-penjualan.pdf');
}

    /**
     * Update Status oleh Admin (Konfirmasi Pembayaran atau Input Resi)
     */
    public function update(Request $request, Order $order)
    {
        if ($request->has('status')) {
            $order->update(['status' => $request->status]);
        }

        if ($request->hasFile('shipping_proof')) {
            $proof = $request->file('shipping_proof')->store('shipping', 'public');
            $order->update([
                'shipping_proof' => $proof,
                'status' => 'shipped'
            ]);
        }

        return back()->with('success', 'Pesanan berhasil diperbarui');
    }

    // Tambahkan di dalam OrderController
public function history()
{
    $userId = Auth::id();
    $orders = Order::where('customer_name', Auth::user()->name)->latest()->get();
    return view('orders.history', compact('orders'));
}

public function downloadPDF()
{
    $orders = Order::all();
    $pdf = Pdf::loadView('admin.orders.report_pdf', compact('orders'));
    return $pdf->download('laporan-penjualan.pdf');
}
}