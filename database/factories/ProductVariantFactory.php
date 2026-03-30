<?php
namespace Database\Factories;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition(): array
    {
        return [
            'product_id' => 1,
            'gia_tri_bien_the' => \json_encode(['Mau sac' => $this->faker->colorName(), 'Kich co' => $this->faker->randomElement(['S', 'M', 'L', 'XL'])]),
            'so_luong' => $this->faker->numberBetween(0, 100),
        ];
    }

    public function withVariants(): self
    {
        return $this->state([
            'gia_tri_bien_the' => \json_encode(['Mau sac' => $this->faker->colorName(), 'Kich co' => $this->faker->randomElement(['S', 'M', 'L', 'XL'])]),
        ]);
    }
}
