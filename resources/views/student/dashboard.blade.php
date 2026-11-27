@extends('layouts.app')

@section('title', 'Dashboard siswa')

@section('content')
    <section>
        <div class="relative overflow-hidden rounded-3xl bg-slate-950 px-6 py-8 sm:px-9 sm:py-10">
            <div class="absolute -right-10 -top-20 size-72 rounded-full bg-emerald-400/10 blur-3xl"></div>
            <div class="relative flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-300">Ruang belajar siswa</p>
                    <h1 class="mt-2 text-3xl font-semibold tracking-tight text-white sm:text-4xl">Halo, {{ auth()->user()->name }}.</h1>
                    <p class="mt-3 max-w-xl text-sm leading-6 text-slate-300">Pilih laboratorium, mulai dari pertanyaan yang menarik perhatianmu, lalu amati apa yang terjadi.</p>
                </div>
                <a href="#pilih-laboratorium" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-emerald-400 px-4 py-3 text-sm font-bold text-slate-950 transition hover:bg-emerald-300">
                    Jelajahi laboratorium <span aria-hidden="true">↓</span>
                </a>
            </div>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['Laboratorium', $statistics['laboratories'], 'Bidang untuk dijelajahi', 'bg-blue-50 text-blue-700'],
                ['Materi tersedia', $statistics['materials'], 'Materi di seluruh bidang', 'bg-violet-50 text-violet-700'],
                ['Eksperimen tersedia', $statistics['experimentsAvailable'], 'Panduan yang bisa dimulai', 'bg-emerald-50 text-emerald-700'],
                ['Kuis dikerjakan', $statistics['quizzesTaken'], 'Evaluasi yang kamu ikuti', 'bg-amber-50 text-amber-700'],
            ] as [$label, $value, $description, $classes])
                <article class="rounded-2xl border border-slate-200 bg-white p-5">
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                        <span class="size-2 rounded-full {{ str_contains($classes, 'blue') ? 'bg-blue-500' : (str_contains($classes, 'violet') ? 'bg-violet-500' : (str_contains($classes, 'emerald') ? 'bg-emerald-500' : 'bg-amber-500')) }}"></span>
                    </div>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">{{ number_format($value) }}</p>
                    <p class="mt-1 text-xs text-slate-500">{{ $description }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-6 grid gap-4 lg:grid-cols-[0.8fr_1.2fr]">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-700">Profil siswa</p>
                <div class="mt-4 flex items-center gap-4">
                    <span class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-lg font-bold text-blue-700" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                    <div class="min-w-0">
                        <h2 class="truncate font-semibold text-slate-950">{{ auth()->user()->name }}</h2>
                        <p class="mt-1 truncate text-sm text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-500">Terdaftar sejak {{ auth()->user()->created_at->translatedFormat('d M Y') }}</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-700">Progres pembelajaran</p>
                        <h2 class="mt-2 font-semibold text-slate-950">Praktikum yang diselesaikan</h2>
                    </div>
                    <span class="text-2xl font-semibold tabular-nums text-slate-950">{{ $progressPercentage }}%</span>
                </div>
                <div class="mt-4 h-2.5 overflow-hidden rounded-full bg-slate-100" role="progressbar" aria-label="Progres praktikum" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $progressPercentage }}">
                    <div class="h-full rounded-full bg-blue-600 transition-all" style="width: {{ $progressPercentage }}%"></div>
                </div>
                <p class="mt-2 text-xs text-slate-500">{{ number_format($statistics['experimentsCompleted']) }} dari {{ number_format($statistics['experimentsAvailable']) }} eksperimen tersedia selesai</p>
            </section>
        </div>

        <div id="pilih-laboratorium" class="mt-10 scroll-mt-24">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-emerald-700">Mulai eksplorasi</p>
                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Pilih laboratorium</h2>
                </div>
                <p class="text-sm text-slate-500">Materi dan progres dihitung dari database.</p>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-3">
                @forelse ($laboratories as $laboratory)
                    @php
                        $theme = match ($laboratory->slug) {
                            'fisika' => ['symbol' => '∿', 'classes' => 'bg-blue-50 text-blue-700'],
                            'kimia' => ['symbol' => '⌬', 'classes' => 'bg-violet-50 text-violet-700'],
                            default => ['symbol' => '✳', 'classes' => 'bg-emerald-50 text-emerald-700'],
                        };
                    @endphp
                    <a href="{{ route('laboratories.show', $laboratory->slug) }}" class="group rounded-2xl border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-lg hover:shadow-slate-900/[0.04]">
                        <div class="flex items-start justify-between gap-4">
                            <span class="flex size-12 items-center justify-center rounded-2xl text-2xl {{ $theme['classes'] }}">{{ $theme['symbol'] }}</span>
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $laboratory->materials_count }} materi · {{ $laboratory->experiments_count }} eksperimen</span>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-slate-950">{{ $laboratory->name }}</h3>
                        <p class="mt-2 min-h-12 text-sm leading-6 text-slate-600">{{ $laboratory->description }}</p>
                        <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-slate-700 transition group-hover:text-emerald-700">
                            Masuk laboratorium <span class="transition group-hover:translate-x-1" aria-hidden="true">→</span>
                        </span>
                    </a>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-sm text-slate-600 md:col-span-3">
                        Katalog laboratorium belum tersedia.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-10 grid gap-6 xl:grid-cols-2">
        <section class="rounded-2xl border border-slate-200 bg-white">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="font-semibold text-slate-950">Aktivitas praktikum terbaru</h2>
                    <p class="mt-1 text-xs text-slate-500">Catatan yang tersimpan di akunmu.</p>
                </div>
                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $recentResults->count() }} catatan</span>
            </div>
            @forelse ($recentResults as $result)
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-4 last:border-b-0 sm:px-6">
                    <div>
                        <p class="text-sm font-semibold text-slate-800">{{ $result->experiment?->title ?? 'Eksperimen tidak tersedia' }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $result->experiment?->laboratory?->name ?? 'Laboratorium' }} · Diperbarui {{ $result->updated_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $result->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                        {{ $result->status === 'completed' ? 'Selesai' : 'Berlangsung' }}
                    </span>
                </div>
            @empty
                <div class="px-5 py-9 text-center sm:px-6">
                    <span class="mx-auto flex size-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-500">∅</span>
                    <p class="mt-3 text-sm font-semibold text-slate-800">Belum ada riwayat praktikum</p>
                    <p class="mt-1 text-sm text-slate-500">Hasil praktikum yang kamu selesaikan akan muncul di sini.</p>
                </div>
            @endforelse
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="font-semibold text-slate-950">Riwayat evaluasi</h2>
                    <p class="mt-1 text-xs text-slate-500">Kuis yang sudah kamu kerjakan.</p>
                </div>
                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $recentQuizResults->count() }} hasil</span>
            </div>
            @forelse ($recentQuizResults as $result)
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-4 last:border-b-0 sm:px-6">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-800">{{ $result->quiz?->title ?? 'Kuis tidak tersedia' }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $result->quiz?->laboratory?->name ?? 'Laboratorium' }} · {{ $result->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <span class="shrink-0 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">Nilai {{ number_format((float) $result->score, 0) }}</span>
                </div>
            @empty
                <div class="px-5 py-9 text-center sm:px-6">
                    <p class="text-sm font-semibold text-slate-800">Belum ada hasil evaluasi</p>
                    <p class="mt-1 text-sm text-slate-500">Hasil kuis yang kamu kerjakan akan tercatat di sini.</p>
                </div>
            @endforelse
        </section>
        </div>
    </section>
@endsection
