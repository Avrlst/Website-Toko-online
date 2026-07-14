<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{HomeController, CategoryController, CartController, AuthController};
use App\Http\Controllers\Admin\{DashboardController, OrderController, ProductController, SliderController};
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\ReviewController;

// --- PUBLIK ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kategori/{slug}', [CategoryController::class, 'show']);
Route::get('/produk/{slug}', [HomeController::class, 'show'])->name('product.detail');

// --- AUTH ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store')->middleware('auth');

// --- CUSTOMER (Wajib Login) ---
Route::middleware(['auth'])->group(function () {
    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', function() {
        $cartItems = \App\Models\Cart::where('user_id', Auth::id())->with('product')->get();
        if($cartItems->isEmpty()) return redirect()->route('cart.index');
        return view('checkout.index', compact('cartItems'));
    })->name('checkout.index');

    Route::post('/checkout/store', [OrderController::class, 'store'])->name('checkout.store');
    
    // Riwayat Pesanan untuk User
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
});

// --- ADMIN ---
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/categories', AdminCategoryController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/orders', OrderController::class)->only(['index', 'show', 'update']);
    Route::resource('sliders', SliderController::class);
    
    // Laporan PDF Admin
    Route::get('/report/orders', [OrderController::class, 'generateReport'])->name('orders.report');
    Route::get('/report/download', [OrderController::class, 'downloadPDF'])->name('orders.pdf');
});