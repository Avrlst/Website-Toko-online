<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])
                ->latest()
                ->take(4)
                ->get();
        $sliders = Slider::where('is_active', true)->orderBy('order')->get();
        $categories = Category::all();
        $products = Product::latest()->take(8)->get();
        
        return view('home', compact('sliders', 'categories', 'products','reviews'));
    
    
    }//

    public function show($slug)
{
    // Cari produk berdasarkan slug, jika tidak ada tampilkan 404
    $product = Product::where('slug', $slug)->firstOrFail();
    
    return view('product-detail', compact('product'));
}
}
