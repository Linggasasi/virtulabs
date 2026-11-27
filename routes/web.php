<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExperimentController as AdminExperimentController;
use App\Http\Controllers\Admin\MaterialController as AdminMaterialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\ExperimentController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPageController::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('register.store');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/laboratories/{laboratory:slug}', [LaboratoryController::class, 'show'])
    ->name('laboratories.show');
Route::get('/materials/{material}', [MaterialController::class, 'show'])
    ->name('materials.show');
Route::get('/experiments/{experiment}', [ExperimentController::class, 'show'])
    ->name('experiments.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:admin')
        ->group(function () {
            Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
                ->name('users.update-role');

            Route::resource('materials', AdminMaterialController::class)->except(['show', 'destroy']);
            Route::resource('experiments', AdminExperimentController::class)->except(['show', 'destroy']);
        });

    Route::prefix('student')
        ->name('student.')
        ->middleware('role:student')
        ->group(function () {
            Route::get('/dashboard', StudentDashboardController::class)->name('dashboard');
        });
});
