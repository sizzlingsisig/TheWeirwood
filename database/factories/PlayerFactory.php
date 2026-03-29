<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'display_name' => fake()->name(),
        ];
    }
}
