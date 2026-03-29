<?php

namespace Database\Factories;

use App\Models\House;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->city(),
            'icon_image_path' => null,
            'house_id' => House::factory(),
            'starting_honor' => fake()->numberBetween(40, 70),
            'starting_power' => fake()->numberBetween(40, 70),
            'starting_debt' => fake()->numberBetween(10, 25),
        ];
    }
}
