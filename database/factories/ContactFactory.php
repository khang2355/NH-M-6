<?php
namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'ten' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'so_dien_thoai' => $this->faker->phoneNumber(),
            'noi_dung' => $this->faker->sentence(10),
        ];
    }
}
