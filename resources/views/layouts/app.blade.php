<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ruang belajar') · VirtuLabs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f7f8f5] font-sans text-slate-900 antialiased">
    <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3.5 sm:px-8" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3">
                <span class="flex size-10 items-center justify-center rounded-2xl bg-blue-600 text-white">
                    <svg viewBox="0 0 24 24" class="size-6" fill="none" aria-hidden="true">
                        <path d="M12 3.5v5m0 7v5M3.5 12h5m7 0h5M6 6l3.5 3.5m5 5L18 18m0-12-3.5 3.5m-5 5L6 18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        <circle cx="12" cy="12" r="3.3" stroke="currentColor" stroke-width="1.7"/>
                    </svg>
                </span>
                <span class="text-sm font-bold tracking-tight">VirtuLabs</span>
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Ringkasan</a>
                @foreach ($navigationLaboratories as $navigationLaboratory)
                    <a href="{{ route('laboratories.show', $navigationLaboratory->slug) }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                        {{ str_replace('Laboratorium ', '', $navigationLaboratory->name) }}
                    </a>
                @endforeach
                @auth
                    @if (auth()->user()->role === \App\UserRole::Administrator)
                        <a href="{{ route('admin.users.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Pengguna</a>
                    @endif
                @endauth
            </div>

            <div class="hidden items-center gap-3 lg:flex">
                @auth
                    <span class="max-w-40 truncate text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-xl border border-slate-200 px-3.5 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl px-3.5 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-slate-900 px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">Daftar</a>
                @endauth
            </div>

            <button id="mobile-menu-button" type="button" class="inline-flex size-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 lg:hidden" aria-controls="mobile-menu" aria-expanded="false" aria-label="Buka navigasi">
                <svg viewBox="0 0 24 24" class="size-5" fill="none" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </button>
        </nav>
        <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white px-5 py-4 lg:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-1">
                <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">Ringkasan</a>
                @foreach ($navigationLaboratories as $navigationLaboratory)
                    <a href="{{ route('laboratories.show', $navigationLaboratory->slug) }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                        {{ $navigationLaboratory->name }}
                    </a>
                @endforeach
                @auth
                    @if (auth()->user()->role === \App\UserRole::Administrator)
                        <a href="{{ route('admin.users.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">Kelola pengguna</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-slate-100 pt-3">
                        @csrf
                        <button type="submit" class="w-full rounded-lg px-3 py-2.5 text-left text-sm font-semibold text-rose-700 hover:bg-rose-50">Keluar dari akun</button>
                    </form>
                @else
                    <div class="mt-2 grid grid-cols-2 gap-3 border-t border-slate-100 pt-3">
                        <a href="{{ route('login') }}" class="rounded-xl border border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-700">Masuk</a>
                        <a href="{{ route('register') }}" class="rounded-xl bg-emerald-600 px-4 py-3 text-center text-sm font-semibold text-white">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <main class="mx-auto min-h-[calc(100vh-9rem)] max-w-7xl px-5 py-8 sm:px-8 sm:py-10">
        @if (session('status'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-5 py-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <span>VirtuLabs</span>
            <span>Belajar sains dengan rasa ingin tahu.</span>
        </div>
    </footer>
</body>
</html>
