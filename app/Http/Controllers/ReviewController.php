<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{
   public function store(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return back()->with('error', 'Anda harus login terlebih dahulu.');
        }

        $request->validate([
            'products_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        Review::create([
            'user_id' => Auth::id(), // Menggunakan Auth::id() lebih stabil
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas ulasannya!');
    }
}
