<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function show(Material $material): View
    {
        $material->load([
            'laboratory:id,name,slug',
            'experiments:id,material_id,title,description',
        ]);

        return view('materials.show', compact('material'));
    }
}
