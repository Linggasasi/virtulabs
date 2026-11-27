@extends('layouts.app')

@section('title', $laboratory->name)

@section('content')
    @php
        $simLinks = match ($laboratory->slug) {
            'fisika' => [
                ['slug' => 'physics', 'label' => 'Simulasi 3D Gerak Parabola'],
                ['slug' => 'electrical', 'label' => 'Simulasi 3D Rangkaian Listrik'],
            ],
            'kimia' => [
                ['slug' => 'chemistry', 'label' => 'Simulasi 3D Reaksi Asam–Basa'],
            ],
            default => [],
        };
    @endphp

    <div class="vl-lab-heading">
        <div>
            <a class="vl-back-link" href="{{ auth()->check() ? route('dashboard') : route('home') }}">
                <i class="vl-icon vl-icon-arrow-left"></i> {{ auth()->check() ? 'Kembali ke ringkasan' : 'Kembali ke beranda' }}
            </a>
            <div class="vl-eyebrow"><span class="vl-eyebrow-line"></span>{{ strtoupper($laboratory->slug) }} LABORATORY</div>
            <h1>{{ $laboratory->name }}</h1>
            <p class="vl-lead">{{ $laboratory->description }}</p>
        </div>
        <div class="vl-lab-meta">
            <span><i class="vl-icon vl-icon-book"></i>{{ $laboratory->materials_count }} materi</span>
            <span><i class="vl-icon vl-icon-lab"></i>{{ $laboratory->experiments_count }} eksperimen</span>
            <span><i class="vl-icon vl-icon-chart"></i>{{ $laboratory->quizzes_count }} kuis</span>
        </div>
    </div>

    @if (count($simLinks) > 0)
        <div class="mb-7 rounded-[19px] border border-[#dce9e1] bg-[#e8f1eb] p-5 sm:flex sm:items-center sm:justify-between sm:gap-6">
            <div>
                <div class="vl-eyebrow">VIRTUAL EXPERIMENT ROOM</div>
                <h2 class="mt-1.5 text-lg font-bold text-[#18343a]">Ruang Praktik 3D Interaktif</h2>
                <p class="mt-1 text-xs leading-relaxed text-[#526e68]">Buka ruang simulasi 3D untuk mengatur parameter alat dan mengamati hasil reaksi atau gerak secara langsung.</p>
            </div>
            <div class="mt-4 flex flex-wrap gap-2.5 sm:mt-0 sm:shrink-0">
                @foreach ($simLinks as $sim)
                    <a href="{{ route('virtulab.lab', $sim['slug']) }}" class="vl-button vl-button-primary">
                        <i class="vl-icon vl-icon-lab"></i> {{ $sim['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="vl-theory-layout">
        <div class="space-y-6">
            <section id="materi" class="vl-theory-main scroll-mt-24">
                <div class="flex items-end justify-between gap-4 border-b border-[#f0f3f1] pb-4">
                    <div>
                        <div class="vl-content-kicker">MATERI PEMBELAJARAN</div>
                        <h2 class="mt-1 text-xl font-bold text-[#18343a]">Topik & modul</h2>
                    </div>
                    <span class="text-xs font-semibold text-[#7d9294]">{{ $laboratory->materials_count }} materi</span>
                </div>

                @if ($materials->isEmpty())
                    <div class="mt-5 rounded-2xl border border-dashed border-[#ccdad3] bg-[#fafcfb] px-5 py-10 text-center">
                        <span class="mx-auto flex size-11 items-center justify-center rounded-2xl bg-white text-[#7d9294] shadow-sm">∅</span>
                        <p class="mt-3 text-sm font-semibold text-[#18343a]">Materi belum tersedia</p>
                        <p class="mt-1 text-xs text-[#859795]">Materi resmi akan tampil di sini setelah ditambahkan administrator.</p>
                    </div>
                @else
                    <div class="mt-4 divide-y divide-[#f0f3f1]">
                        @foreach ($materials as $index => $material)
                            <article class="flex flex-col gap-3 py-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-start gap-3.5 min-w-0">
                                    <span class="vl-concept-number mt-0.5">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-[#18343a]">{{ $material->title }}</h3>
                                        <p class="mt-1 text-xs leading-relaxed text-[#7d9294]">{{ $material->description ?: 'Pelajari konsep dan istilah penting pada topik ini.' }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('materials.show', $material) }}" class="vl-arrow-link shrink-0">
                                    Mulai belajar <i class="vl-icon vl-icon-arrow"></i>
                                </a>
                            </article>
                        @endforeach
                    </div>
                    @if ($materials->hasPages())
                        <div class="mt-5">{{ $materials->links() }}</div>
                    @endif
                @endif
            </section>

            <section class="vl-theory-main">
                <div class="flex items-end justify-between gap-4 border-b border-[#f0f3f1] pb-4">
                    <div>
                        <div class="vl-content-kicker">PANDUAN EKSPERIMEN</div>
                        <h2 class="mt-1 text-xl font-bold text-[#18343a]">Daftar praktikum</h2>
                    </div>
                    <span class="text-xs font-semibold text-[#7d9294]">{{ $laboratory->experiments_count }} eksperimen</span>
                </div>

                @if ($experiments->isEmpty())
                    <div class="mt-5 rounded-2xl border border-dashed border-[#ccdad3] bg-[#fafcfb] px-5 py-10 text-center">
                        <p class="text-sm font-semibold text-[#18343a]">Eksperimen belum tersedia</p>
                        <p class="mt-1 text-xs text-[#859795]">Panduan praktikum akan tampil di sini setelah ditambahkan administrator.</p>
                    </div>
                @else
                    <div class="mt-4 divide-y divide-[#f0f3f1]">
                        @foreach ($experiments as $experiment)
                            <article class="flex flex-col gap-4 py-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <h3 class="font-bold text-[#18343a]">{{ $experiment->title }}</h3>
                                    <p class="mt-1 text-xs leading-relaxed text-[#7d9294]">{{ $experiment->description ?: 'Panduan eksperimen virtual' }}</p>
                                    @if ($experiment->material)
                                        <p class="mt-1 text-[11px] font-medium text-[#5c9b88]">Materi: {{ $experiment->material->title }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('experiments.show', $experiment) }}" class="vl-button vl-button-primary shrink-0">
                                    Mulai eksperimen <i class="vl-icon vl-icon-arrow-right"></i>
                                </a>
                            </article>
                        @endforeach
                    </div>
                    @if ($experiments->hasPages())
                        <div class="mt-5">{{ $experiments->links() }}</div>
                    @endif
                @endif
            </section>
        </div>

        <aside class="vl-theory-aside">
            <div class="vl-formula-card">
                <div class="vl-aside-heading">
                    <span class="vl-aside-icon"><i class="vl-icon vl-icon-chart"></i></span>
                    <span><strong>Ringkasan bidang</strong><small>Statistik dari database</small></span>
                </div>
                <div class="vl-formula-row"><small>Materi tersedia</small><strong>{{ number_format($laboratory->materials_count) }} modul</strong></div>
                <div class="vl-formula-row"><small>Panduan eksperimen</small><strong>{{ number_format($laboratory->experiments_count) }} percobaan</strong></div>
                <div class="vl-formula-row"><small>Evaluasi kuis</small><strong>{{ number_format($laboratory->quizzes_count) }} kuis</strong></div>
            </div>

            <div class="vl-info-card">
                <i class="vl-icon vl-icon-lightbulb"></i>
                <div>
                    <strong>Eksplorasi 3D Interaktif</strong>
                    <p>Ingin langsung mencoba simulasi 3D interaktif? Buka katalog ruang praktik 3D kami.</p>
                    <a href="{{ route('virtulab.index') }}" class="vl-button vl-button-outline vl-full">
                        Buka katalog 3D <i class="vl-icon vl-icon-arrow-right"></i>
                    </a>
                </div>
            </div>
        </aside>
    </div>
@endsection
