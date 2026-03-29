<?php

namespace Database\Factories;

use App\Models\House;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<House>
 */
class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'motto' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'sigil_image_path' => null,
            'starting_honor' => fake()->numberBetween(0, 100),
            'starting_power' => fake()->numberBetween(0, 100),
            'starting_debt' => fake()->numberBetween(0, 100),
        ];
    }
}
