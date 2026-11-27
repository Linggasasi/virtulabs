<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'VirtuLab' }} · VirtuLab</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/virtulab.css', 'resources/js/virtulab.js'])
</head>
<body class="vl-body">
    <div class="vl-app-shell">
        <aside class="vl-sidebar" id="vlSidebar">
            <a class="vl-brand" href="{{ route('virtulab.index') }}">
                <span class="vl-brand-mark"><i class="vl-icon vl-icon-flask"></i></span>
                <span><strong>VirtuLab</strong><small>INTERACTIVE SCIENCE LAB</small></span>
            </a>

            <div class="vl-nav-label">WORKSPACE</div>
            <nav class="vl-nav">
                <a href="{{ route('virtulab.index') }}" class="vl-nav-link {{ request()->routeIs('virtulab.index') ? 'is-active' : '' }}">
                    <i class="vl-icon vl-icon-grid"></i><span>Dashboard</span>
                </a>
                @foreach($labs as $item)
                    <a href="{{ route('virtulab.lab', $item['slug']) }}" class="vl-nav-link {{ request()->route('slug') === $item['slug'] ? 'is-active' : '' }}">
                        <i class="vl-icon {{ $item['slug'] === 'physics' ? 'vl-icon-atom' : ($item['slug'] === 'chemistry' ? 'vl-icon-flask' : 'vl-icon-bolt') }}"></i>
                        <span>{{ $item['name'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="vl-nav-label vl-nav-label-spaced">LEARNING</div>
            <a href="{{ route('virtulab.index') }}#learning-path" class="vl-nav-link"><i class="vl-icon vl-icon-book"></i><span>Materi & Modul</span></a>

            <div class="vl-sidebar-bottom">
                <div class="vl-sidebar-note">
                    <span class="vl-note-dot"></span>
                    <strong>Ruang belajar digital</strong>
                    <p>Pelajari konsep sains, lakukan eksperimen virtual, lalu amati hasilnya secara langsung.</p>
                </div>
                <div class="vl-user-mini"><span class="vl-avatar">ST</span><span><strong>Student Workspace</strong><small>Student account</small></span></div>
            </div>
        </aside>

        <main class="vl-main">
            <header class="vl-topbar">
                <button class="vl-mobile-menu" id="vlMobileMenu" aria-label="Buka navigasi"><i class="vl-icon vl-icon-menu"></i></button>
                <div class="vl-breadcrumb"><a href="{{ route('virtulab.index') }}">Workspace</a><span>›</span><strong>{{ $pageTitle ?? 'Dashboard' }}</strong></div>
                <div class="vl-topbar-actions">
                    <span class="vl-online"><span></span> LAB ONLINE</span>
                    <button class="vl-help-button" title="Informasi"><i class="vl-icon vl-icon-help"></i></button>
                </div>
            </header>
            <div class="vl-content">
                @yield('content')
            </div>
        </main>
    </div>
    <div class="vl-toast" id="vlToast" role="status" aria-live="polite"></div>
</body>
</html>
