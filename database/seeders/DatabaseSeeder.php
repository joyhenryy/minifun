<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@minifun.com'],
            [
                'name' => 'MINIFUN Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Categories
        $categories = [
            ['name' => 'Diecast Cars', 'slug' => 'diecast-cars'],
            ['name' => 'Diecast Trucks', 'slug' => 'diecast-trucks'],
            ['name' => 'Diecast Motorcycles', 'slug' => 'diecast-motorcycles'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
            ['name' => 'Limited Edition', 'slug' => 'limited-edition'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Sample products
        $products = [
            [
                'name' => 'Hot Wheels 2024 Ford Mustang GT',
                'slug' => 'hot-wheels-2024-ford-mustang-gt',
                'description' => 'The iconic Ford Mustang GT in a stunning 1:64 scale diecast model. Features detailed interior, authentic body lines, and metallic blue paint finish. A must-have for any Mustang enthusiast.',
                'price' => 85000,
                'shopee_url' => 'https://shopee.co.id/',
                'is_featured' => true,
                'category_id' => 1,
            ],
            [
                'name' => 'Tomica Toyota GR Supra',
                'slug' => 'tomica-toyota-gr-supra',
                'description' => 'Premium Tomica release of the Toyota GR Supra in racing yellow. 1:64 scale with opening doors and detailed engine bay. Japanese precision craftsmanship at its finest.',
                'price' => 120000,
                'shopee_url' => 'https://shopee.co.id/',
                'is_featured' => true,
                'category_id' => 1,
            ],
            [
                'name' => 'Matchbox Lamborghini Countach',
                'slug' => 'matchbox-lamborghini-countach',
                'description' => 'The legendary Lamborghini Countach in classic white. This 1:64 scale Matchbox model captures the wedge-shaped supercar perfectly with detailed wheels and authentic proportions.',
                'price' => 75000,
                'shopee_url' => 'https://shopee.co.id/',
                'is_featured' => true,
                'category_id' => 1,
            ],
            [
                'name' => 'Hot Wheels Monster Truck Bone Shaker',
                'slug' => 'hot-wheels-monster-truck-bone-shaker',
                'description' => 'Massive 1:24 scale Monster Truck with oversized wheels and skull-themed body. Features working suspension and free-rolling wheels for epic monster truck action.',
                'price' => 250000,
                'shopee_url' => 'https://shopee.co.id/',
                'is_featured' => true,
                'category_id' => 2,
            ],
            [
                'name' => 'Maisto Harley-Davidson Fat Boy',
                'slug' => 'maisto-harley-davidson-fat-boy',
                'description' => 'Detailed 1:18 scale replica of the iconic Harley-Davidson Fat Boy. Chrome-finished engine, rubber tires, and working kick stand. A premium collector piece.',
                'price' => 350000,
                'shopee_url' => 'https://shopee.co.id/',
                'is_featured' => false,
                'category_id' => 3,
            ],
            [
                'name' => 'Hot Wheels Track Builder Curve Pack',
                'slug' => 'hot-wheels-track-builder-curve-pack',
                'description' => 'Expand your Hot Wheels track system with this curve pack. Includes 8 curve pieces and 2 connectors. Compatible with all Hot Wheels track systems.',
                'price' => 150000,
                'shopee_url' => 'https://shopee.co.id/',
                'is_featured' => false,
                'category_id' => 4,
            ],
            [
                'name' => 'Kyosho Ferrari F40 Limited',
                'slug' => 'kyosho-ferrari-f40-limited',
                'description' => 'Ultra-rare limited edition 1:64 scale Ferrari F40 by Kyosho. Only 5000 pieces worldwide. Features opening rear engine cover revealing the twin-turbo V8. Premium packaging included.',
                'price' => 500000,
                'shopee_url' => 'https://shopee.co.id/',
                'is_featured' => true,
                'category_id' => 5,
            ],
            [
                'name' => 'Mini GT Nissan GT-R R35',
                'slug' => 'mini-gt-nissan-gt-r-r35',
                'description' => 'The legendary Godzilla in 1:64 scale by Mini GT. Detailed Bayside Blue paint, opening hood, and realistic brake calipers. Premium diecast quality with rubber tires.',
                'price' => 180000,
                'shopee_url' => 'https://shopee.co.id/',
                'is_featured' => true,
                'category_id' => 1,
            ],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(['slug' => $prod['slug']], $prod);
        }
    }
}
