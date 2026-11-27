<?php

namespace Database\Factories;

use App\Models\Experiment;
use App\Models\ExperimentResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExperimentResult>
 */
class ExperimentResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'experiment_id' => Experiment::factory(),
            'observation' => fake()->paragraph(),
            'conclusion' => null,
            'score' => null,
            'status' => 'in_progress',
            'completed_at' => null,
        ];
    }
}
