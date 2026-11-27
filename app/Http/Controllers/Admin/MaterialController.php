<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaterialRequest;
use App\Models\Laboratory;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        return view('admin.materials.index', [
            'materials' => Material::query()
                ->select(['id', 'laboratory_id', 'title', 'description', 'created_at', 'updated_at'])
                ->with('laboratory:id,name')
                ->withCount('experiments')
                ->latest()
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.materials.form', [
            'material' => null,
            'laboratories' => Laboratory::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(MaterialRequest $request): RedirectResponse
    {
        Material::query()->create($request->validated());

        return redirect()
            ->route('admin.materials.index')
            ->with('status', 'Materi berhasil ditambahkan.');
    }

    public function edit(Material $material): View
    {
        return view('admin.materials.form', [
            'material' => $material,
            'laboratories' => Laboratory::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(MaterialRequest $request, Material $material): RedirectResponse
    {
        $material->update($request->validated());

        return redirect()
            ->route('admin.materials.index')
            ->with('status', 'Materi berhasil diperbarui.');
    }
}
