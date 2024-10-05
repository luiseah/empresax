<?php

namespace Database\Factories;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        $id = fake()->uuid();
        return [
            'name' => "Product # {$id}",
            'status' => fake()->randomElement(ProductStatusEnum::cases()),
            'price' => fake()->randomElement([
                1, 10, 100, 200, 300
            ]),
            'stock' => fake()->numberBetween(1, 10),
            'ean_13' => fake()->ean13(),
        ];
    }
}
