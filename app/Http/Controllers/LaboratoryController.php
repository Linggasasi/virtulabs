<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use Illuminate\View\View;

class LaboratoryController extends Controller
{
    public function show(Laboratory $laboratory): View
    {
        $laboratory->loadCount(['materials', 'experiments', 'quizzes']);

        return view('laboratories.show', [
            'laboratory' => $laboratory,
            'materials' => $laboratory->materials()
                ->latest()
                ->paginate(6, ['id', 'laboratory_id', 'title', 'description', 'created_at'], 'materials_page'),
            'experiments' => $laboratory->experiments()
                ->with('material:id,title')
                ->latest()
                ->paginate(
                    6,
                    ['id', 'laboratory_id', 'material_id', 'title', 'description', 'created_at'],
                    'experiments_page',
                ),
        ]);
    }
}
