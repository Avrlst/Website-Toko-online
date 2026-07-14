<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));//
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));//
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric',
        'stock'       => 'required|integer',
        'description' => 'required',
        'care'        => 'nullable',
        'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // ⬇️ INI BARU KODE KAMU
    $image = $request->file('image')->store('products', 'public');

    Product::create([
        'category_id' => $request->category_id,
        'name'        => $request->name,
        'slug'        => Str::slug($request->name),
        'price'       => $request->price,
        'stock'       => $request->stock,
        'description' => $request->description,
        'care'        => $request->care,
        'image'       => $image,
    ]);

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Produk berhasil ditambahkan');//
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $product = Product::findOrFail($id); // Mencari data, jika tidak ada akan muncul error 404 (bukan blank)
        $categories = Category::all(); // Biasanya dibutuhkan untuk dropdown kategori
        
        return view('admin.products.edit', compact('product', 'categories'));  //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        $product->delete();

        return redirect()->back()->with('success','Berhasil menghapus Produk');
    }
    
    
}
