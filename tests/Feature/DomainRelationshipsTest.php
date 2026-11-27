<?php

namespace Tests\Feature;

use App\Models\Experiment;
use App\Models\ExperimentResult;
use App\Models\Laboratory;
use App\Models\Material;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomainRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_laboratory_learning_and_result_relationships_are_persisted(): void
    {
        $user = User::factory()->create();
        $laboratory = Laboratory::factory()->create();
        $material = Material::factory()->for($laboratory)->create();
        $experiment = Experiment::factory()
            ->for($laboratory)
            ->for($material)
            ->create();
        $experimentResult = ExperimentResult::factory()
            ->for($user)
            ->for($experiment)
            ->create();
        $quiz = Quiz::factory()->for($laboratory)->create();
        $question = Question::factory()->for($quiz)->create();
        $quizResult = QuizResult::factory()->for($user)->for($quiz)->create();

        $this->assertTrue($laboratory->fresh()->materials->sole()->is($material));
        $this->assertTrue($material->experiments->sole()->is($experiment));
        $this->assertTrue($experiment->results->sole()->is($experimentResult));
        $this->assertTrue($user->fresh()->experimentResults->sole()->is($experimentResult));
        $this->assertTrue($quiz->questions->sole()->is($question));
        $this->assertTrue($quiz->results->sole()->is($quizResult));
        $this->assertTrue($quizResult->user->is($user));
        $this->assertTrue($quizResult->quiz->is($quiz));
    }
}
