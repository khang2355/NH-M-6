<?php
namespace Database\Factories;

use App\Models\ProductVariantImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantImageFactory extends Factory
{
    protected $model = ProductVariantImage::class;

    public function definition(): array
    {
        return [
            'product_variant_id' => 1,
            'hinh_anh' => tao_anh_giay_lap('variants', 'Variant'),
        ];
    }
}
