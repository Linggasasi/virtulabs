@extends('layouts.guest')

@section('title', 'Laboratorium kelas virtual')
@section('meta-description', 'Belajar Fisika, Kimia, dan Biologi lewat pengalaman laboratorium virtual yang interaktif dan aman.')

@section('content')
    <main class="mx-auto max-w-[1360px] px-5 py-9 sm:px-9 sm:py-12">
        <section class="rounded-[24px] border border-[#e5ece9] bg-white p-7 sm:p-11">
            <div class="vl-welcome-row">
                <div class="max-w-2xl">
                    <div class="vl-eyebrow"><span class="vl-eyebrow-line"></span> VIRTUAL SCIENCE LEARNING</div>
                    <h1>Rasa ingin tahu adalah <span>awal penemuan.</span></h1>
                    <p class="vl-lead">
                        Pilih bidang sains, pelajari teori dan panduan praktikum, lalu lakukan eksperimen virtual 3D secara interaktif dalam satu ruang belajar digital.
                    </p>
                    <div class="mt-7 flex flex-wrap items-center gap-3">
                        <a href="{{ route('register') }}" class="vl-button vl-button-primary">
                            Mulai belajar <i class="vl-icon vl-icon-arrow-right"></i>
                        </a>
                        <a href="{{ route('virtulab.index') }}" class="vl-button vl-button-outline">
                            <i class="vl-icon vl-icon-lab"></i> Coba Simulasi 3D
                        </a>
                        <a href="#laboratorium" class="vl-button vl-button-soft">
                            Jelajahi laboratorium
                        </a>
                    </div>
                </div>

                <div class="vl-welcome-art hidden sm:grid" aria-hidden="true">
                    <div class="vl-orbit orbit-one"></div>
                    <div class="vl-orbit orbit-two"></div>
                    <div class="vl-art-core"><i class="vl-icon vl-icon-atom"></i></div>
                    <span class="vl-art-dot dot-a"></span>
                    <span class="vl-art-dot dot-b"></span>
                </div>
            </div>
        </section>

        <section class="vl-stat-grid" aria-label="Keunggulan VirtuLabs">
            <article class="vl-stat-card">
                <span class="vl-stat-icon mint"><i class="vl-icon vl-icon-flask"></i></span>
                <div>
                    <small>LABORATORIUM</small>
                    <strong>{{ str_pad((string) max($laboratories->count(), 3), 2, '0', STR_PAD_LEFT) }}</strong>
                    <span>Bidang Fisika, Kimia &amp; Biologi</span>
                </div>
            </article>
            <article class="vl-stat-card">
                <span class="vl-stat-icon sand"><i class="vl-icon vl-icon-book"></i></span>
                <div>
                    <small>ALUR BELAJAR</small>
                    <strong>2 Mode</strong>
                    <span>Materi teori &amp; praktik interaktif</span>
                </div>
            </article>
            <article class="vl-stat-card">
                <span class="vl-stat-icon blue"><i class="vl-icon vl-icon-chart"></i></span>
                <div>
                    <small>WORKBENCH 3D</small>
                    <strong>Real-time</strong>
                    <span>Eksperimen virtual berbasis WebGL</span>
                </div>
            </article>
        </section>

        <section id="laboratorium" class="scroll-mt-24">
            <div class="vl-section-heading">
                <div>
                    <div class="vl-eyebrow">PILIH RUANG PRAKTIK</div>
                    <h2>Jelajahi laboratorium</h2>
                    <p>Pilih bidang untuk mempelajari materi, panduan eksperimen, dan simulasi interaktif.</p>
                </div>
                <span class="vl-section-count">{{ str_pad((string) $laboratories->count(), 2, '0', STR_PAD_LEFT) }} LABS</span>
            </div>

            <div class="vl-lab-grid">
                @forelse ($laboratories as $laboratory)
                    @php
                        $visualKey = match ($laboratory->slug) {
                            'fisika' => 'physics',
                            'kimia' => 'chemistry',
                            default => 'electrical',
                        };
                        $subjectLabel = str_replace('Laboratorium ', '', $laboratory->name);
                    @endphp
                    <article class="vl-lab-card lab-{{ $visualKey }}">
                        <div class="vl-lab-card-top">
                            <span class="vl-subject-pill">{{ $subjectLabel }}</span>
                            <span class="vl-card-duration"><i class="vl-icon vl-icon-signal"></i>Interaktif</span>
                        </div>
                        <div class="vl-lab-illustration illustration-{{ $visualKey }}" aria-hidden="true">
                            @if ($visualKey === 'physics')
                                <div class="physics-platform"></div><div class="physics-launcher"></div><div class="physics-ball"></div><div class="physics-target"></div>
                            @elseif ($visualKey === 'chemistry')
                                <div class="chem-bottle bottle-left"><span></span></div><div class="chem-beaker"><span></span></div><div class="chem-bottle bottle-right"><span></span></div>
                            @else
                                <div class="circuit-board"><span class="circuit-line"></span><span class="circuit-resistor r-one"></span><span class="circuit-resistor r-two"></span><span class="circuit-bulb"></span></div>
                            @endif
                        </div>
                        <div class="vl-lab-card-body">
                            <div class="vl-card-kicker">{{ strtoupper($laboratory->slug) }} LABORATORY</div>
                            <h3>{{ $laboratory->name }}</h3>
                            <p>{{ $laboratory->description }}</p>
                            <div class="vl-card-footer">
                                <span class="vl-level"><i class="vl-icon vl-icon-book"></i>Materi &amp; Praktik</span>
                                <a href="{{ route('laboratories.show', $laboratory->slug) }}" class="vl-arrow-link">
                                    Lihat lab <i class="vl-icon vl-icon-arrow"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-[19px] border border-dashed border-[#ccdad3] bg-white p-8 text-sm text-[#7d9294] md:col-span-3">
                        Katalog laboratorium belum tersedia. Jalankan seeder katalog untuk menyiapkan bidang pembelajaran.
                    </div>
                @endforelse
            </div>
        </section>

        <section id="cara-belajar" class="vl-how-panel scroll-mt-24">
            <div class="vl-how-copy">
                <div class="vl-eyebrow">LEARNING FLOW</div>
                <h2>Belajar dengan cara yang lebih nyata.</h2>
                <p>Setiap laboratorium dirancang dengan alur sederhana agar konsep yang dipelajari langsung terhubung dengan praktik.</p>
            </div>
            <div class="vl-flow-steps">
                <div class="vl-flow-step">
                    <span>01</span>
                    <strong>Pelajari teori</strong>
                    <small>Pahami konsep, rumus, dan tujuan eksperimen.</small>
                </div>
                <i class="vl-icon vl-icon-arrow-right"></i>
                <div class="vl-flow-step">
                    <span>02</span>
                    <strong>Lakukan praktik</strong>
                    <small>Atur alat dan parameter dalam ruang 3D virtual.</small>
                </div>
                <i class="vl-icon vl-icon-arrow-right"></i>
                <div class="vl-flow-step">
                    <span>03</span>
                    <strong>Amati hasil</strong>
                    <small>Bandingkan hasil dan tulis kesimpulan.</small>
                </div>
            </div>
        </section>

        <section class="mt-7 overflow-hidden rounded-[22px] p-8 text-center text-white sm:p-12" style="background: linear-gradient(165deg,#102a31,#173a40 70%,#15343b);">
            <div class="mx-auto max-w-2xl">
                <p class="text-[10px] font-extrabold uppercase tracking-[1.8px] text-[#83aaa5]">LABORATORIUM KELAS VIRTUAL</p>
                <h2 class="mt-3 font-['Manrope'] text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                    Pertanyaan sainsmu layak untuk dijelajahi.
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-[#c3d8d4]">
                    Buat akun siswa untuk menyimpan progres praktikum, mencoba simulasi 3D, dan mencatat hasil pengamatanmu.
                </p>
                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('register') }}" class="rounded-xl bg-[#bce4d6] px-5 py-3 text-xs font-extrabold text-[#102a31] transition hover:bg-white">
                        Daftar gratis
                    </a>
                    <a href="{{ route('virtulab.index') }}" class="rounded-xl border border-white/20 px-5 py-3 text-xs font-bold text-[#e5f1ec] transition hover:bg-white/10">
                        Buka katalog 3D
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
