<?php

namespace Database\Factories;

use App\Models\Laboratory;
use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'laboratory_id' => Laboratory::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'image' => null,
        ];
    }
}
