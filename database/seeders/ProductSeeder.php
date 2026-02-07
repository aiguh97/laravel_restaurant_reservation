<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // 5 Produk Makanan Indonesia (category_id 1)
            [
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan bumbu khas Indonesia.',
                'price' => 25000,
                'stock' => 50,
                'category_id' => 1,
                'image' => 'https://source.unsplash.com/640x480/?nasi,goreng,indonesia',
                'is_best_seller' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sate Ayam',
                'description' => 'Sate ayam dengan bumbu kacang manis.',
                'price' => 30000,
                'stock' => 40,
                'category_id' => 1,
                'image' => 'https://source.unsplash.com/640x480/?sate,ayam,indonesia',
                'is_best_seller' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rendang Daging',
                'description' => 'Rendang daging khas Padang.',
                'price' => 45000,
                'stock' => 30,
                'category_id' => 1,
                'image' => 'https://source.unsplash.com/640x480/?rendang,indonesia',
                'is_best_seller' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gado-Gado',
                'description' => 'Salad khas Indonesia dengan saus kacang.',
                'price' => 20000,
                'stock' => 60,
                'category_id' => 1,
                'image' => 'https://source.unsplash.com/640x480/?gado-gado,indonesia',
                'is_best_seller' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bakso Sapi',
                'description' => 'Bakso sapi kenyal dengan kuah hangat.',
                'price' => 22000,
                'stock' => 55,
                'category_id' => 1,
                'image' => 'https://source.unsplash.com/640x480/?bakso,indonesia',
                'is_best_seller' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 5 Produk Minuman (category_id 2)
            [
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis segar dengan es batu.',
                'price' => 8000,
                'stock' => 100,
                'category_id' => 2,
                'image' => 'https://source.unsplash.com/640x480/?iced,tea',
                'is_best_seller' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jus Jeruk',
                'description' => 'Jus jeruk segar tanpa gula tambahan.',
                'price' => 12000,
                'stock' => 80,
                'category_id' => 2,
                'image' => 'https://source.unsplash.com/640x480/?orange,juice',
                'is_best_seller' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kopi Tubruk',
                'description' => 'Kopi tradisional khas Indonesia.',
                'price' => 10000,
                'stock' => 70,
                'category_id' => 2,
                'image' => 'https://source.unsplash.com/640x480/?coffee',
                'is_best_seller' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Susu Cokelat',
                'description' => 'Susu cokelat hangat dan manis.',
                'price' => 15000,
                'stock' => 60,
                'category_id' => 2,
                'image' => 'https://source.unsplash.com/640x480/?chocolate,milk',
                'is_best_seller' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Air Mineral',
                'description' => 'Air mineral segar kemasan botol.',
                'price' => 5000,
                'stock' => 200,
                'category_id' => 2,
                'image' => 'https://source.unsplash.com/640x480/?water',
                'is_best_seller' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 5 Produk Snack/Cemilan Indonesia (category_id 3)
            [
                'name' => 'Kue Lapis',
                'description' => 'Kue lapis tradisional Indonesia.',
                'price' => 20000,
                'stock' => 40,
                'category_id' => 3,
                'image' => 'https://source.unsplash.com/640x480/?kue,lapis,indonesia',
                'is_best_seller' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Keripik Singkong',
                'description' => 'Keripik singkong renyah dan gurih.',
                'price' => 15000,
                'stock' => 50,
                'category_id' => 3,
                'image' => 'https://source.unsplash.com/640x480/?keripik,singkong,indonesia',
                'is_best_seller' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pisang Goreng',
                'description' => 'Pisang goreng hangat dan manis.',
                'price' => 18000,
                'stock' => 60,
                'category_id' => 3,
                'image' => 'https://source.unsplash.com/640x480/?pisang,goreng,indonesia',
                'is_best_seller' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Onde-Onde',
                'description' => 'Cemilan tradisional berisi kacang hijau.',
                'price' => 15000,
                'stock' => 45,
                'category_id' => 3,
                'image' => 'https://source.unsplash.com/640x480/?onde-onde,indonesia',
                'is_best_seller' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kue Cubit',
                'description' => 'Kue cubit manis dan lembut.',
                'price' => 12000,
                'stock' => 55,
                'category_id' => 3,
                'image' => 'https://source.unsplash.com/640x480/?kue,cubit,indonesia',
                'is_best_seller' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
