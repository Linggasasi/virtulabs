<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExperimentRequest;
use App\Models\Experiment;
use App\Models\Laboratory;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExperimentController extends Controller
{
    public function index(): View
    {
        return view('admin.experiments.index', [
            'experiments' => Experiment::query()
                ->select(['id', 'laboratory_id', 'material_id', 'title', 'description', 'created_at', 'updated_at'])
                ->with(['laboratory:id,name', 'material:id,title'])
                ->withCount('results')
                ->latest()
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.experiments.form', [
            'experiment' => null,
            'laboratories' => Laboratory::query()->orderBy('name')->get(['id', 'name']),
            'materials' => Material::query()
                ->with('laboratory:id,name')
                ->orderBy('title')
                ->get(['id', 'laboratory_id', 'title']),
        ]);
    }

    public function store(ExperimentRequest $request): RedirectResponse
    {
        Experiment::query()->create($request->validated());

        return redirect()
            ->route('admin.experiments.index')
            ->with('status', 'Eksperimen berhasil ditambahkan.');
    }

    public function edit(Experiment $experiment): View
    {
        return view('admin.experiments.form', [
            'experiment' => $experiment,
            'laboratories' => Laboratory::query()->orderBy('name')->get(['id', 'name']),
            'materials' => Material::query()
                ->with('laboratory:id,name')
                ->orderBy('title')
                ->get(['id', 'laboratory_id', 'title']),
        ]);
    }

    public function update(ExperimentRequest $request, Experiment $experiment): RedirectResponse
    {
        $experiment->update($request->validated());

        return redirect()
            ->route('admin.experiments.index')
            ->with('status', 'Eksperimen berhasil diperbarui.');
    }
}
