@extends('layouts.app')

@section('content')
    <div class="grid min-w-0 gap-6 lg:grid-cols-[15rem_minmax(0,1fr)]">
        <aside class="h-fit w-full min-w-0 rounded-2xl border border-slate-200 bg-white p-3 lg:sticky lg:top-24" aria-label="Navigasi administrator">
            <div class="px-3 py-2">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-700">Administrator</p>
                <p class="mt-1 text-xs text-slate-500">Kelola ruang belajar</p>
            </div>
            <nav class="mt-2 flex w-full min-w-0 max-w-full gap-1 overflow-x-auto lg:flex-col" aria-label="Menu admin">
                <a href="{{ route('admin.dashboard') }}"
                    @class([
                        'shrink-0 rounded-xl px-3 py-2.5 text-sm font-semibold transition',
                        'bg-blue-50 text-blue-800' => request()->routeIs('admin.dashboard'),
                        'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('admin.dashboard'),
                    ])
                    @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                    Ringkasan
                </a>
                <a href="{{ route('admin.users.index') }}"
                    @class([
                        'shrink-0 rounded-xl px-3 py-2.5 text-sm font-semibold transition',
                        'bg-blue-50 text-blue-800' => request()->routeIs('admin.users.*'),
                        'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('admin.users.*'),
                    ])
                    @if (request()->routeIs('admin.users.*')) aria-current="page" @endif>
                    Pengguna
                </a>
                <a href="{{ route('admin.materials.index') }}"
                    @class([
                        'shrink-0 rounded-xl px-3 py-2.5 text-sm font-semibold transition',
                        'bg-blue-50 text-blue-800' => request()->routeIs('admin.materials.*'),
                        'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('admin.materials.*'),
                    ])
                    @if (request()->routeIs('admin.materials.*')) aria-current="page" @endif>
                    Materi
                </a>
                <a href="{{ route('admin.experiments.index') }}"
                    @class([
                        'shrink-0 rounded-xl px-3 py-2.5 text-sm font-semibold transition',
                        'bg-blue-50 text-blue-800' => request()->routeIs('admin.experiments.*'),
                        'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('admin.experiments.*'),
                    ])
                    @if (request()->routeIs('admin.experiments.*')) aria-current="page" @endif>
                    Eksperimen
                </a>
            </nav>
        </aside>

        <div class="min-w-0">
            @yield('admin-content')
        </div>
    </div>
@endsection
