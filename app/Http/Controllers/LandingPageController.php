<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function __invoke(): View
    {
        return view('welcome', [
            'laboratories' => Laboratory::query()->orderBy('id')->get(),
        ]);
    }
}
