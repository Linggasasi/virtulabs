<?php

namespace App\Http\Controllers;

use App\Models\Experiment;
use Illuminate\View\View;

class ExperimentController extends Controller
{
    public function show(Experiment $experiment): View
    {
        $experiment->load([
            'laboratory:id,name,slug',
            'material:id,title',
        ]);

        return view('experiments.show', compact('experiment'));
    }
}
