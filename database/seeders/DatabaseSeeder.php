<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);
        \App\Models\User::factory(3)->create();

        // Variant Types
        $loaiBienThe = \App\Models\VariantType::factory()->count(2)->sequence(
            ['ten' => 'Mau sac'],
            ['ten' => 'Kich co']
        )->create();

        // Categories
        $danhMucs = \App\Models\Category::factory(2)->sequence(
            ['ten' => 'Thời trang'],
            ['ten' => 'Điện tử']
        )->create();
        foreach ($danhMucs as $danhMuc) {
            $danhMuc->variantTypes()->attach($loaiBienThe->pluck('id'));
        }

        // Products
        foreach ($danhMucs as $danhMuc) {
            $products = \App\Models\Product::factory(2)->create(['category_id' => $danhMuc->id]);
            foreach ($products as $product) {
                // Product Variants - manually create with JSON encoding
                for ($i = 0; $i < 2; $i++) {
                    $variant = \App\Models\ProductVariant::create([
                        'product_id' => $product->id,
                        'gia_tri_bien_the' => \json_encode(['Mau sac' => fake()->colorName(), 'Kich co' => fake()->randomElement(['S', 'M', 'L', 'XL'])]),
                        'so_luong' => fake()->numberBetween(5, 100),
                    ]);
                    // Product Variant Images
                    \App\Models\ProductVariantImage::factory(1)->create(['product_variant_id' => $variant->id]);
                }
            }
        }

        // Banners
        \App\Models\Banner::factory(2)->create();
        // Contacts
        \App\Models\Contact::factory(2)->create();
        // Carts
        $cart = \App\Models\Cart::factory()->create(['user_id' => 1]);
        // Cart Items
        \App\Models\CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_variant_id' => 1,
            'so_luong' => 2
        ]);
    }
}
