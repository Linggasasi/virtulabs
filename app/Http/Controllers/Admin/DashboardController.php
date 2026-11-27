<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experiment;
use App\Models\ExperimentResult;
use App\Models\Laboratory;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\User;
use App\UserRole;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'statistics' => [
                'students' => User::query()->where('role', UserRole::Student->value)->count(),
                'administrators' => User::query()->where('role', UserRole::Administrator->value)->count(),
                'laboratories' => Laboratory::query()->count(),
                'materials' => Material::query()->count(),
                'experiments' => Experiment::query()->count(),
                'quizzes' => Quiz::query()->count(),
                'completedExperiments' => ExperimentResult::query()
                    ->where('status', 'completed')
                    ->count(),
            ],
            'activityByLaboratory' => Laboratory::query()
                ->leftJoin('experiments', 'experiments.laboratory_id', '=', 'laboratories.id')
                ->leftJoin('experiment_results', 'experiment_results.experiment_id', '=', 'experiments.id')
                ->select(['laboratories.id', 'laboratories.name', 'laboratories.slug'])
                ->selectRaw('COUNT(experiment_results.id) AS attempts')
                ->selectRaw(
                    'SUM(CASE WHEN experiment_results.status = ? THEN 1 ELSE 0 END) AS completed',
                    ['completed'],
                )
                ->groupBy('laboratories.id', 'laboratories.name', 'laboratories.slug')
                ->orderBy('laboratories.name')
                ->get(),
            'recentStudents' => User::query()
                ->where('role', UserRole::Student->value)
                ->latest()
                ->limit(5)
                ->get(['id', 'name', 'email', 'created_at']),
        ]);
    }
}
