<?php
namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition(): array
    {
        return [
            'hinh_anh' => tao_anh_giay_lap('banners', 'Banner ' . $this->faker->word),
            'vi_tri' => $this->faker->numberBetween(1, 3),
        ];
    }
}

