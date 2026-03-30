<?php
namespace Database\Factories;

use App\Models\VariantType;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariantTypeFactory extends Factory
{
    protected $model = VariantType::class;

    public function definition(): array
    {
        return [
            'ten' => $this->faker->randomElement(['Mau sac', 'Kich co', 'Chat lieu', 'Kieu dang']),
        ];
    }
}
