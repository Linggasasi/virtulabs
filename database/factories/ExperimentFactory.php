<?php

namespace Database\Factories;

use App\Models\Experiment;
use App\Models\Laboratory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experiment>
 */
class ExperimentFactory extends Factory
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
            'material_id' => null,
            'title' => fake()->sentence(4),
            'description' => fake()->sentence(),
            'objectives' => fake()->paragraph(),
            'instructions' => fake()->paragraphs(2, true),
            'simulation_type' => null,
        ];
    }
}
