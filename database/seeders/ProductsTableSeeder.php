<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        
        Product::create([
            'sku' => 'SKU-001',
            'product_name' => 'Iphone X',
            'description' => 'Iphone X with iOS 9, 64GB storage',
            'price' => 999.99,
        ]);

        Product::create([
            'sku' => 'SKU-002',
            'product_name' => 'Samsung Galaxy S10',
            'description' => 'Samsung Galaxy S10 with Android 10, 128GB storage',
            'price' => 799.99,
        ]);

        Product::create([
            'sku' => 'SKU-003',
            'product_name' => 'Google Pixel 5',
            'description' => 'Google Pixel 5 with Android 11, 128GB storage',
            'price' => 699.99,
        ]);
        
    }
}

