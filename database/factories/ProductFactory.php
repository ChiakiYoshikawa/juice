<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->numberBetween(1, 6),
            'product_name' => $this->faker->word,
            'price' => $this->faker->numberBetween(10, 800),
            'stock' => $this->faker->numberBetween(0, 100),
            'comment' => $this->faker->sentence,
            'img_path' => 'public/' . $this->faker->image(storage_path('app/public/images/products'), 400, 300, 'drinks', false, true),
        ];
    }
}
