<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Experiment;
use App\Models\ExperimentResult;
use App\Models\Laboratory;
use App\Models\Material;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $student = $request->user();
        $experimentsAvailable = Experiment::query()->count();
        $experimentsCompleted = ExperimentResult::query()
            ->whereBelongsTo($student, 'user')
            ->where('status', 'completed')
            ->distinct()
            ->count('experiment_id');

        return view('student.dashboard', [
            'statistics' => [
                'laboratories' => Laboratory::query()->count(),
                'materials' => Material::query()->count(),
                'experimentsAvailable' => $experimentsAvailable,
                'experimentsCompleted' => $experimentsCompleted,
                'quizzesTaken' => QuizResult::query()
                    ->whereBelongsTo($student, 'user')
                    ->count(),
            ],
            'progressPercentage' => $experimentsAvailable === 0
                ? 0
                : min(100, (int) round($experimentsCompleted / $experimentsAvailable * 100)),
            'laboratories' => Laboratory::query()
                ->withCount(['materials', 'experiments'])
                ->orderBy('name')
                ->get(),
            'recentResults' => ExperimentResult::query()
                ->whereBelongsTo($student, 'user')
                ->with([
                    'experiment:id,title,laboratory_id',
                    'experiment.laboratory:id,name',
                ])
                ->latest('updated_at')
                ->limit(5)
                ->get(),
            'recentQuizResults' => QuizResult::query()
                ->whereBelongsTo($student, 'user')
                ->with([
                    'quiz:id,title,laboratory_id',
                    'quiz.laboratory:id,name',
                ])
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }
}
