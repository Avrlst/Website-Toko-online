<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // Tambahkan semua kolom yang boleh diisi di sini
    protected $fillable = [
        'category_id', // Ini yang menyebabkan error tadi
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
    ];
    
    public function category()
{
    return $this->belongsTo(Category::class);
}
public function reviews() {
    return $this->hasMany(Review::class);
}
}
