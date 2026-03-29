<?php

namespace Database\Factories;

use App\Models\House;
use App\Models\Node;
use App\Models\Player;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'house_id' => House::factory(),
            'region_id' => Region::factory(),
            'entry_mode' => fake()->randomElement(['commoner', 'quiz', 'map', 'blind']),
            'honor' => fake()->numberBetween(30, 75),
            'power' => fake()->numberBetween(30, 75),
            'debt' => fake()->numberBetween(10, 30),
            'current_node_id' => Node::factory(),
            'is_complete' => false,
            'session_started' => now(),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_complete' => true,
            'session_ended' => now(),
        ]);
    }
}
