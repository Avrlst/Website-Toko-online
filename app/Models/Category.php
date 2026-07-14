<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mengizinkan input data
    protected $fillable = [
        'name', 
        'slug', 
        'image'
    ];

    /**
     * Relasi ke Produk (Satu kategori punya banyak produk)
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
