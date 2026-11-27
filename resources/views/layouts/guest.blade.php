<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta-description', 'Laboratorium virtual untuk belajar sains melalui eksperimen yang interaktif.')">
    <title>@yield('title', 'VirtuLabs') · VirtuLabs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/virtulab.css', 'resources/js/virtulab.js'])
</head>
<body class="vl-body antialiased">
    <header class="sticky top-0 z-30 border-b border-[#e5ece9] bg-white/95 backdrop-blur-md">
        <nav class="mx-auto flex h-[76px] max-w-[1360px] items-center justify-between px-5 sm:px-9" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-[#18343a]" aria-label="VirtuLabs, beranda">
                <span class="flex size-11 items-center justify-center rounded-[14px] bg-[#bce4d6] text-[#16444a] shadow-sm">
                    <i class="vl-icon vl-icon-flask"></i>
                </span>
                <span class="leading-tight">
                    <span class="block font-['Manrope'] text-lg font-extrabold tracking-tight text-[#18343a]">VirtuLabs</span>
                    <span class="block text-[9px] font-bold tracking-[1.8px] text-[#71908b]">INTERACTIVE SCIENCE LAB</span>
                </span>
            </a>

            <div class="hidden items-center gap-7 md:flex">
                <a href="#laboratorium" class="text-[13px] font-semibold text-[#526e68] transition hover:text-[#347f70]">Laboratorium</a>
                <a href="{{ route('virtulab.index') }}" class="text-[13px] font-semibold text-[#526e68] transition hover:text-[#347f70]">Simulasi 3D</a>
                <a href="#cara-belajar" class="text-[13px] font-semibold text-[#526e68] transition hover:text-[#347f70]">Cara belajar</a>
            </div>

            <div class="hidden items-center gap-2.5 md:flex">
                <span class="vl-online mr-1"><span></span> LAB ONLINE</span>
                @auth
                    <a href="{{ route('dashboard') }}" class="vl-button vl-button-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="vl-button vl-button-outline">Masuk</a>
                    <a href="{{ route('register') }}" class="vl-button vl-button-primary">Mulai belajar</a>
                @endauth
            </div>

            <button id="mobile-menu-button" type="button" class="inline-flex size-10 items-center justify-center rounded-xl border border-[#e5ece9] bg-white text-[#526e68] md:hidden" aria-controls="mobile-menu" aria-expanded="false" aria-label="Buka navigasi">
                <i class="vl-icon vl-icon-menu"></i>
            </button>
        </nav>

        <div id="mobile-menu" class="hidden border-t border-[#e5ece9] bg-white px-5 py-4 md:hidden">
            <div class="mx-auto flex max-w-[1360px] flex-col gap-1">
                <a href="#laboratorium" class="rounded-xl px-3 py-2.5 text-sm font-semibold text-[#294a50] hover:bg-[#f4f7f5]">Laboratorium</a>
                <a href="{{ route('virtulab.index') }}" class="rounded-xl px-3 py-2.5 text-sm font-semibold text-[#294a50] hover:bg-[#f4f7f5]">Simulasi 3D</a>
                <a href="#cara-belajar" class="rounded-xl px-3 py-2.5 text-sm font-semibold text-[#294a50] hover:bg-[#f4f7f5]">Cara belajar</a>
                <div class="mt-2 grid grid-cols-2 gap-2.5 border-t border-[#edf2ef] pt-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="vl-button vl-button-primary col-span-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="vl-button vl-button-outline">Masuk</a>
                        <a href="{{ route('register') }}" class="vl-button vl-button-primary">Daftar siswa</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="border-t border-[#e5ece9] bg-white">
        <div class="mx-auto flex max-w-[1360px] flex-col gap-3 px-5 py-7 text-xs text-[#7d9294] sm:flex-row sm:items-center sm:justify-between sm:px-9">
            <a href="{{ route('home') }}" class="font-['Manrope'] text-sm font-bold text-[#18343a]">VirtuLabs</a>
            <p>Ruang belajar sains digital yang aman, interaktif, dan dapat diakses kapan saja.</p>
        </div>
    </footer>
</body>
</html>
