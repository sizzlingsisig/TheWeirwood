<?php

namespace Database\Factories;

use App\Models\Node;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'from_node_id' => Node::factory(),
            'to_node_id' => Node::factory(),
            'display_order' => fake()->numberBetween(1, 5),
            'required_house_id' => null,
            'choice_text' => fake()->sentence(),
            'hint_text' => fake()->boolean(50) ? fake()->sentence() : null,
            'honor_delta' => fake()->numberBetween(-20, 20),
            'power_delta' => fake()->numberBetween(-20, 20),
            'debt_delta' => fake()->numberBetween(-10, 30),
            'locks_on_high_debt' => false,
        ];
    }
}
