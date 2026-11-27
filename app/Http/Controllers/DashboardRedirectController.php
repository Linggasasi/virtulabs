<?php

namespace App\Http\Controllers;

use App\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardRedirectController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        return match ($request->user()->role) {
            UserRole::Administrator => redirect()->route('admin.dashboard'),
            UserRole::Student => redirect()->route('student.dashboard'),
        };
    }
}
