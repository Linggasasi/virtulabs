<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ruang belajar') · VirtuLabs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/virtulab.css', 'resources/js/virtulab.js'])
</head>
<body class="vl-body antialiased">
    <div class="vl-app-shell">
        <aside class="vl-sidebar" id="vlSidebar">
            <a class="vl-brand" href="{{ route('home') }}">
                <span class="vl-brand-mark"><i class="vl-icon vl-icon-flask"></i></span>
                <span><strong>VirtuLabs</strong><small>INTERACTIVE SCIENCE LAB</small></span>
            </a>

            <div class="vl-nav-label">WORKSPACE</div>
            <nav class="vl-nav" aria-label="Navigasi utama">
                <a href="{{ auth()->check() ? route('dashboard') : route('home') }}"
                    class="vl-nav-link {{ request()->routeIs('dashboard', 'student.dashboard', 'admin.dashboard') ? 'is-active' : '' }}">
                    <i class="vl-icon vl-icon-grid"></i><span>Ringkasan</span>
                </a>

                @foreach ($navigationLaboratories as $navigationLaboratory)
                    @php
                        $navIcon = match ($navigationLaboratory->slug) {
                            'fisika' => 'vl-icon-atom',
                            'kimia' => 'vl-icon-flask',
                            default => 'vl-icon-lab',
                        };
                        $isCurrentLab = request()->routeIs('laboratories.show')
                            && request()->route('laboratory')?->slug === $navigationLaboratory->slug;
                    @endphp
                    <a href="{{ route('laboratories.show', $navigationLaboratory->slug) }}"
                        class="vl-nav-link {{ $isCurrentLab ? 'is-active' : '' }}">
                        <i class="vl-icon {{ $navIcon }}"></i>
                        <span>{{ str_replace('Laboratorium ', '', $navigationLaboratory->name) }}</span>
                    </a>
                @endforeach

                @auth
                    @if (auth()->user()->role === \App\UserRole::Administrator)
                        <a href="{{ route('admin.users.index') }}"
                            class="vl-nav-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">
                            <i class="vl-icon vl-icon-sliders"></i><span>Kelola Pengguna</span>
                        </a>
                    @endif
                @endauth
            </nav>

            <div class="vl-nav-label vl-nav-label-spaced">SIMULASI 3D</div>
            <nav class="vl-nav" aria-label="Simulasi 3D Interaktif">
                <a href="{{ route('virtulab.index') }}"
                    class="vl-nav-link {{ request()->routeIs('virtulab.index') ? 'is-active' : '' }}">
                    <i class="vl-icon vl-icon-book"></i><span>Katalog Lab 3D</span>
                </a>
                <a href="{{ route('virtulab.lab', 'physics') }}"
                    class="vl-nav-link {{ request()->routeIs('virtulab.lab') && request()->route('slug') === 'physics' ? 'is-active' : '' }}">
                    <i class="vl-icon vl-icon-atom"></i><span>Gerak Parabola</span>
                </a>
                <a href="{{ route('virtulab.lab', 'chemistry') }}"
                    class="vl-nav-link {{ request()->routeIs('virtulab.lab') && request()->route('slug') === 'chemistry' ? 'is-active' : '' }}">
                    <i class="vl-icon vl-icon-flask"></i><span>Reaksi Asam–Basa</span>
                </a>
                <a href="{{ route('virtulab.lab', 'electrical') }}"
                    class="vl-nav-link {{ request()->routeIs('virtulab.lab') && request()->route('slug') === 'electrical' ? 'is-active' : '' }}">
                    <i class="vl-icon vl-icon-bolt"></i><span>Rangkaian Listrik</span>
                </a>
            </nav>

            <div class="vl-sidebar-bottom">
                <div class="vl-sidebar-note">
                    <span class="vl-note-dot"></span>
                    <strong>Ruang belajar digital</strong>
                    <p>Pelajari konsep sains, lakukan eksperimen virtual 3D, lalu amati hasilnya secara langsung.</p>
                </div>

                @auth
                    <div class="vl-user-mini">
                        <span class="vl-avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 2)) }}</span>
                        <div class="min-w-0 flex-1">
                            <strong class="truncate">{{ auth()->user()->name }}</strong>
                            <small>{{ auth()->user()->role === \App\UserRole::Administrator ? 'Administrator' : 'Student account' }}</small>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Keluar" class="rounded-lg border border-white/15 bg-white/5 px-2.5 py-1.5 text-[11px] font-semibold text-[#c3d8d4] transition hover:bg-white/15 hover:text-white">
                                Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-5 grid grid-cols-2 gap-2 border-t border-white/15 pt-4">
                        <a href="{{ route('login') }}" class="rounded-xl border border-white/20 px-3 py-2 text-center text-xs font-semibold text-[#d7eee5] transition hover:bg-white/10">Masuk</a>
                        <a href="{{ route('register') }}" class="rounded-xl bg-[#bce4d6] px-3 py-2 text-center text-xs font-bold text-[#102a31] transition hover:bg-white">Daftar</a>
                    </div>
                @endauth
            </div>
        </aside>

        <main class="vl-main">
            <header class="vl-topbar">
                <button class="vl-mobile-menu" id="vlMobileMenu" type="button" aria-label="Buka navigasi">
                    <i class="vl-icon vl-icon-menu"></i>
                </button>
                <div class="vl-breadcrumb">
                    <a href="{{ auth()->check() ? route('dashboard') : route('home') }}">Workspace</a>
                    <span>›</span>
                    <strong>@yield('title', 'Ruang belajar')</strong>
                </div>
                <div class="vl-topbar-actions">
                    <span class="vl-online"><span></span> LAB ONLINE</span>
                    <a href="{{ route('virtulab.index') }}" class="hidden rounded-xl border border-[#dce8e1] bg-[#edf6f0] px-3 py-2 text-xs font-bold text-[#347d6d] transition hover:bg-[#dff0e6] sm:inline-flex sm:items-center sm:gap-1.5">
                        <i class="vl-icon vl-icon-lab"></i> Ruang 3D
                    </a>
                </div>
            </header>

            <div class="vl-content">
                @if (session('status'))
                    <div class="mb-6 rounded-2xl border border-[#a6d3c2] bg-[#edf6f0] px-4 py-3 text-sm font-medium text-[#286b60]" role="status">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <div class="vl-toast" id="vlToast" role="status" aria-live="polite"></div>
</body>
</html>
