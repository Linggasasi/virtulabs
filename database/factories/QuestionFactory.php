<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'question' => fake()->sentence(),
            'option_a' => fake()->sentence(),
            'option_b' => fake()->sentence(),
            'option_c' => fake()->sentence(),
            'option_d' => fake()->sentence(),
            'correct_answer' => 'A',
        ];
    }
}
