<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $categories = [
            ['name' => 'Tanaman', 'image' => 'categories/tanaman.webp'],
            ['name' => 'Bibit', 'image' => 'categories/bibit.webp'],
            ['name' => 'Pupuk', 'image' => 'categories/pupuk.webp'],
        ]; //

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'image' => $cat['image'],
            ]);
        }
    }
}
