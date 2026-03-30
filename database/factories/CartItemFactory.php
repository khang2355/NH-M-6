<?php
namespace Database\Factories;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition(): array
    {
        return [
            'cart_id' => 1, // sẽ cập nhật trong seeder
            'product_variant_id' => 1, // sẽ cập nhật trong seeder
            'so_luong' => $this->faker->numberBetween(1, 5),
        ];
    }
}
