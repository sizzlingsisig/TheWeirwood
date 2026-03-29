<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NodeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'node_code' => fake()->unique()->bothify('NODE_###'),
            'chapter_label' => 'Chapter '.fake()->numberBetween(1, 10).': '.fake()->words(3, true),
            'title' => fake()->sentence(3),
            'art_image_path' => null,
            'narrative_text' => fake()->paragraphs(2, true),
            'debt_warning_text' => fake()->boolean(30) ? fake()->sentence() : null,
            'debt_warning_threshold' => fake()->numberBetween(50, 80),
            'is_ending' => false,
        ];
    }

    public function ending(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_ending' => true,
            'debt_warning_text' => null,
        ]);
    }
}
