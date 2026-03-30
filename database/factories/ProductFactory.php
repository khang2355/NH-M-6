<?php
namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $gia_ban = $this->faker->numberBetween(100000, 2000000);
        $gia_nhap = $this->faker->numberBetween(50000, $gia_ban - 10000);
        $gia_sale = $this->faker->boolean(70) ? $this->faker->numberBetween($gia_nhap + 10000, $gia_ban) : $gia_ban;
        return [
            'ten' => $this->faker->words(3, true),
            'mo_ta' => $this->faker->paragraph(),
            'category_id' => 1, // sẽ cập nhật trong seeder
            'gia_nhap' => $gia_nhap,
            'gia_ban' => $gia_ban,
            'gia_sale' => $gia_sale,
        ];
    }
}
