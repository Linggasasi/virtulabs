@extends('layouts.app')

@section('title', 'Dashboard siswa')

@section('content')
    <section class="vl-welcome-row">
        <div>
            <div class="vl-eyebrow"><span class="vl-eyebrow-line"></span> VIRTUAL SCIENCE LEARNING</div>
            <h1>Halo, <span>{{ auth()->user()->name }}.</span></h1>
            <p class="vl-lead">Ruang praktikum digital untuk memahami sains melalui eksplorasi, materi terstruktur, dan simulasi 3D interaktif.</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="#pilih-laboratorium" class="vl-button vl-button-primary">
                    Jelajahi laboratorium <i class="vl-icon vl-icon-arrow-right"></i>
                </a>
                <a href="{{ route('virtulab.index') }}" class="vl-button vl-button-outline">
                    <i class="vl-icon vl-icon-lab"></i> Buka Simulasi 3D
                </a>
            </div>
        </div>
        <div class="vl-welcome-art" aria-hidden="true">
            <div class="vl-orbit orbit-one"></div>
            <div class="vl-orbit orbit-two"></div>
            <div class="vl-art-core"><i class="vl-icon vl-icon-atom"></i></div>
            <span class="vl-art-dot dot-a"></span>
            <span class="vl-art-dot dot-b"></span>
        </div>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mt-5 mb-9" aria-label="Ringkasan pembelajaran">
        <article class="vl-stat-card">
            <span class="vl-stat-icon mint"><i class="vl-icon vl-icon-flask"></i></span>
            <div>
                <small>LABORATORIUM</small>
                <strong>{{ str_pad((string) $statistics['laboratories'], 2, '0', STR_PAD_LEFT) }}</strong>
                <span>Bidang untuk dijelajahi</span>
            </div>
        </article>
        <article class="vl-stat-card">
            <span class="vl-stat-icon sand"><i class="vl-icon vl-icon-book"></i></span>
            <div>
                <small>MATERI TERSEDIA</small>
                <strong>{{ str_pad((string) $statistics['materials'], 2, '0', STR_PAD_LEFT) }}</strong>
                <span>Materi di seluruh bidang</span>
            </div>
        </article>
        <article class="vl-stat-card">
            <span class="vl-stat-icon blue"><i class="vl-icon vl-icon-lab"></i></span>
            <div>
                <small>EKSPERIMEN TERSEDIA</small>
                <strong>{{ str_pad((string) $statistics['experimentsAvailable'], 2, '0', STR_PAD_LEFT) }}</strong>
                <span>Panduan yang bisa dimulai</span>
            </div>
        </article>
        <article class="vl-stat-card">
            <span class="vl-stat-icon mint"><i class="vl-icon vl-icon-chart"></i></span>
            <div>
                <small>KUIS DIKERJAKAN</small>
                <strong>{{ str_pad((string) $statistics['quizzesTaken'], 2, '0', STR_PAD_LEFT) }}</strong>
                <span>Evaluasi yang kamu ikuti</span>
            </div>
        </article>
    </section>

    <div class="grid gap-4 lg:grid-cols-[0.85fr_1.15fr] mb-10">
        <section class="rounded-[19px] border border-[#e7eeea] bg-white p-6">
            <div class="vl-content-kicker">PROFIL SISWA</div>
            <div class="mt-4 flex items-center gap-4">
                <span class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-[#edf5f0] font-bold text-[#347f70]" aria-hidden="true">
                    {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                </span>
                <div class="min-w-0">
                    <h2 class="truncate text-base font-bold text-[#18343a]">{{ auth()->user()->name }}</h2>
                    <p class="mt-0.5 truncate text-xs text-[#7d9294]">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <p class="mt-4 text-xs text-[#859795]">Terdaftar sejak {{ auth()->user()->created_at->translatedFormat('d M Y') }}</p>
        </section>

        <section class="rounded-[19px] border border-[#e7eeea] bg-white p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="vl-content-kicker uppercase">Progres pembelajaran</div>
                    <h2 class="mt-1.5 text-base font-bold text-[#18343a]">Praktikum yang diselesaikan</h2>
                </div>
                <span class="text-2xl font-extrabold tabular-nums text-[#347f70]">{{ $progressPercentage }}%</span>
            </div>
            <div class="mt-4 h-2.5 overflow-hidden rounded-full bg-[#edf5f0]" role="progressbar" aria-label="Progres praktikum" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $progressPercentage }}">
                <div class="h-full rounded-full bg-[#3d8c7c] transition-all" style="width: {{ $progressPercentage }}%"></div>
            </div>
            <p class="mt-2.5 text-xs text-[#7d9294]">
                {{ number_format($statistics['experimentsCompleted']) }} dari {{ number_format($statistics['experimentsAvailable']) }} eksperimen tersedia selesai
            </p>
        </section>
    </div>

    <section class="vl-section-heading scroll-mt-24" id="pilih-laboratorium">
        <div>
            <div class="vl-eyebrow">PILIH RUANG PRAKTIK</div>
            <h2>Jelajahi laboratorium</h2>
            <p>Pilih topik untuk mempelajari materi dan melakukan eksperimen virtual.</p>
        </div>
        <span class="vl-section-count">{{ str_pad((string) $laboratories->count(), 2, '0', STR_PAD_LEFT) }} LABS</span>
    </section>

    <section class="vl-lab-grid">
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
                    <span class="vl-card-duration"><i class="vl-icon vl-icon-book"></i>{{ $laboratory->materials_count }} materi · {{ $laboratory->experiments_count }} eksperimen</span>
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
                        <span class="vl-level"><i class="vl-icon vl-icon-signal"></i>Interaktif</span>
                        <a href="{{ route('laboratories.show', $laboratory->slug) }}" class="vl-arrow-link">
                            Masuk lab <i class="vl-icon vl-icon-arrow"></i>
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-[19px] border border-dashed border-[#ccdad3] bg-white p-6 text-sm text-[#7d9294] md:col-span-3">
                Katalog laboratorium belum tersedia.
            </div>
        @endforelse
    </section>

    <section class="vl-how-panel">
        <div class="vl-how-copy">
            <div class="vl-eyebrow">LEARNING FLOW</div>
            <h2>Belajar dengan cara yang lebih nyata.</h2>
            <p>Setiap laboratorium dirancang dengan alur sederhana agar konsep yang dipelajari langsung terhubung dengan praktik.</p>
        </div>
        <div class="vl-flow-steps">
            <div class="vl-flow-step"><span>01</span><strong>Pelajari teori</strong><small>Pahami konsep, rumus, dan tujuan eksperimen.</small></div>
            <i class="vl-icon vl-icon-arrow-right"></i>
            <div class="vl-flow-step"><span>02</span><strong>Lakukan praktik</strong><small>Atur alat dan parameter dalam ruang 3D virtual.</small></div>
            <i class="vl-icon vl-icon-arrow-right"></i>
            <div class="vl-flow-step"><span>03</span><strong>Amati hasil</strong><small>Bandingkan hasil dan tulis kesimpulan.</small></div>
        </div>
    </section>

    <div class="mt-8 grid gap-5 xl:grid-cols-2">
        <section class="rounded-[19px] border border-[#e7eeea] bg-white overflow-hidden">
            <div class="flex items-center justify-between border-b border-[#edf2ef] px-6 py-4">
                <div>
                    <h2 class="text-sm font-bold text-[#18343a]">Aktivitas praktikum terbaru</h2>
                    <p class="mt-0.5 text-xs text-[#859795]">Catatan yang tersimpan di akunmu.</p>
                </div>
                <span class="rounded-full bg-[#edf5f0] px-2.5 py-1 text-[11px] font-bold text-[#3d8c7c]">{{ $recentResults->count() }} catatan</span>
            </div>
            @forelse ($recentResults as $result)
                <div class="flex items-center justify-between gap-4 border-b border-[#f0f3f1] px-6 py-4 last:border-b-0">
                    <div>
                        <p class="text-sm font-semibold text-[#18343a]">{{ $result->experiment?->title ?? 'Eksperimen tidak tersedia' }}</p>
                        <p class="mt-1 text-xs text-[#7d9294]">{{ $result->experiment?->laboratory?->name ?? 'Laboratorium' }} · Diperbarui {{ $result->updated_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $result->status === 'completed' ? 'bg-[#eaf5ef] text-[#347f70]' : 'bg-[#f6eee1] text-[#a7834f]' }}">
                        {{ $result->status === 'completed' ? 'Selesai' : 'Berlangsung' }}
                    </span>
                </div>
            @empty
                <div class="px-6 py-9 text-center">
                    <span class="mx-auto flex size-11 items-center justify-center rounded-2xl bg-[#f4f7f5] text-[#7d9294]">∅</span>
                    <p class="mt-3 text-sm font-semibold text-[#18343a]">Belum ada riwayat praktikum</p>
                    <p class="mt-1 text-xs text-[#859795]">Hasil praktikum yang kamu selesaikan akan muncul di sini.</p>
                </div>
            @endforelse
        </section>

        <section class="rounded-[19px] border border-[#e7eeea] bg-white overflow-hidden">
            <div class="flex items-center justify-between border-b border-[#edf2ef] px-6 py-4">
                <div>
                    <h2 class="text-sm font-bold text-[#18343a]">Riwayat evaluasi</h2>
                    <p class="mt-0.5 text-xs text-[#859795]">Kuis yang sudah kamu kerjakan.</p>
                </div>
                <span class="rounded-full bg-[#edf5f0] px-2.5 py-1 text-[11px] font-bold text-[#3d8c7c]">{{ $recentQuizResults->count() }} hasil</span>
            </div>
            @forelse ($recentQuizResults as $result)
                <div class="flex items-center justify-between gap-4 border-b border-[#f0f3f1] px-6 py-4 last:border-b-0">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-[#18343a]">{{ $result->quiz?->title ?? 'Kuis tidak tersedia' }}</p>
                        <p class="mt-1 text-xs text-[#7d9294]">{{ $result->quiz?->laboratory?->name ?? 'Laboratorium' }} · {{ $result->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <span class="shrink-0 rounded-full bg-[#e8f0f4] px-2.5 py-1 text-xs font-semibold text-[#395e58]">Nilai {{ number_format((float) $result->score, 0) }}</span>
                </div>
            @empty
                <div class="px-6 py-9 text-center">
                    <p class="text-sm font-semibold text-[#18343a]">Belum ada hasil evaluasi</p>
                    <p class="mt-1 text-xs text-[#859795]">Hasil kuis yang kamu kerjakan akan tercatat di sini.</p>
                </div>
            @endforelse
        </section>
    </div>
@endsection
