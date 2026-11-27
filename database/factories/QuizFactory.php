<?php

namespace Database\Factories;

use App\Models\Laboratory;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
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
        ];
    }
}
