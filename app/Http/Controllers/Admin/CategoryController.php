<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
 //     // 1. Ambil semua data kategori dari database
    $categories = Category::all();

    // 2. Kirim variabel $categories ke view
    return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.create', compact('categories'));//
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $imagePath = $request->file('image')->store('categories', 'public');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('categories', 'public');
        }

        Category::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'image' => $imagePath
    ]);
    return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    
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
        $category = Category::findOrFail($id);

    // 2. Kirim data ke view admin/categories/edit.blade.php
    return view('admin.categories.edit', compact('category'));////
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       // 1. Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // 2. Cari kategori
    $category = Category::findOrFail($id);

    // 3. Update data
    $category->update([
        'name' => $request->name,
        // Jika Anda menggunakan slug, jangan lupa update juga
        'slug' => Str::slug($request->name), 
    ]);

    // 4. Redirect kembali dengan pesan sukses
    return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!'); //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->back()->with('success','Berhasil menghapus Kategori');
        //
    }
}
