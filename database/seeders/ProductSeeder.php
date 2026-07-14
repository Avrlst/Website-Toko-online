<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $tanaman = Category::where('slug', 'tanaman')->first();

        Product::create([
            'category_id' => $tanaman->id,
            'name' => 'Monstera',
            'slug' => 'monstera',
            'price' => 75000,
            'stock' => 10,
            'description' => 'Tanaman hias indoor',
            'care' => 'Siram 2x seminggu',
            'image' => 'products/monstera.webp'
        ]); //
    }
}
