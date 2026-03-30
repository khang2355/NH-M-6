<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'ten' => $this->faker->word(),
            'mo_ta' => $this->faker->sentence(),
            'hinh_anh' => tao_anh_giay_lap('categories', 'Category'),
        ];
    }
}
