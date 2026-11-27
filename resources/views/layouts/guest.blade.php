<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta-description', 'Laboratorium virtual untuk belajar sains melalui eksperimen yang interaktif.')">
    <title>@yield('title', 'VirtuLabs') · VirtuLabs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f7f8f5] font-sans text-slate-900 antialiased">
    <header class="relative z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 sm:px-8" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="Virtual Laboratory, beranda">
                <span class="flex size-10 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-500/20">
                    <svg viewBox="0 0 24 24" class="size-6" fill="none" aria-hidden="true">
                        <path d="M12 3.5v5m0 7v5M3.5 12h5m7 0h5M6 6l3.5 3.5m5 5L18 18m0-12-3.5 3.5m-5 5L6 18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        <circle cx="12" cy="12" r="3.3" stroke="currentColor" stroke-width="1.7"/>
                    </svg>
                </span>
                <span class="leading-tight">
                    <span class="block text-sm font-bold tracking-tight">VirtuLabs</span>
                    <span class="block text-[11px] font-medium text-slate-500">Belajar sains, lebih nyata</span>
                </span>
            </a>

            <x-jakarta-clock />

            <div class="hidden items-center gap-8 md:flex">
                <a href="#laboratorium" class="text-sm font-medium text-slate-600 transition hover:text-emerald-700">Laboratorium</a>
                <a href="#cara-belajar" class="text-sm font-medium text-slate-600 transition hover:text-emerald-700">Cara belajar</a>
                <a href="#tentang" class="text-sm font-medium text-slate-600 transition hover:text-emerald-700">Tentang</a>
            </div>

            <div class="hidden items-center gap-3 md:flex">
                <a href="{{ route('login') }}" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Masuk</a>
                <a href="{{ route('register') }}" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">Mulai belajar</a>
            </div>

            <button id="mobile-menu-button" type="button" class="inline-flex size-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 md:hidden" aria-controls="mobile-menu" aria-expanded="false" aria-label="Buka navigasi">
                <svg viewBox="0 0 24 24" class="size-5" fill="none" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </button>
        </nav>
        <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white px-5 py-4 md:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-1">
                <a href="#laboratorium" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">Laboratorium</a>
                <a href="#cara-belajar" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">Cara belajar</a>
                <a href="#tentang" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">Tentang</a>
                <div class="mt-2 grid grid-cols-2 gap-3 border-t border-slate-100 pt-4">
                    <a href="{{ route('login') }}" class="rounded-xl border border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-700">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-emerald-600 px-4 py-3 text-center text-sm font-semibold text-white">Daftar siswa</a>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-5 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <a href="{{ route('home') }}" class="font-semibold text-slate-700">VirtuLabs</a>
            <p>Ruang belajar sains yang aman, interaktif, dan dapat diakses kapan saja.</p>
        </div>
    </footer>
</body>
</html>
