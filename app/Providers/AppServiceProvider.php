<?php

namespace App\Providers;

use App\Models\Laboratory;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request): Limit {
            $key = Str::transliterate(
                Str::lower($request->string('email')).'|'.$request->ip(),
            );

            return Limit::perMinute(5)->by($key);
        });

        ViewFacade::composer('layouts.app', function (View $view): void {
            $view->with(
                'navigationLaboratories',
                Laboratory::query()->orderBy('id')->get(['name', 'slug']),
            );
        });
    }
}
