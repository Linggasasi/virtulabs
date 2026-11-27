@extends('layouts.app')

@section('title', $laboratory->name)

@section('content')
    <section>
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-emerald-700">
            <span aria-hidden="true">←</span> {{ auth()->check() ? 'Kembali ke ringkasan' : 'Kembali ke beranda' }}
        </a>

        @php
            $theme = match ($laboratory->slug) {
                'fisika' => ['symbol' => '∿', 'label' => 'Energi dan gerak', 'classes' => 'bg-blue-50 text-blue-700'],
                'kimia' => ['symbol' => '⌬', 'label' => 'Materi dan reaksi', 'classes' => 'bg-violet-50 text-violet-700'],
                default => ['symbol' => '✳', 'label' => 'Kehidupan dan alam', 'classes' => 'bg-emerald-50 text-emerald-700'],
            };
        @endphp

        <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white">
            <div class="relative overflow-hidden bg-slate-950 px-6 py-9 sm:px-10 sm:py-12">
                <div class="absolute -right-10 -top-20 size-72 rounded-full bg-emerald-400/10 blur-3xl"></div>
                <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center">
                    <span class="flex size-16 shrink-0 items-center justify-center rounded-2xl text-3xl {{ $theme['classes'] }}">{{ $theme['symbol'] }}</span>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-300">{{ $theme['label'] }}</p>
                        <h1 class="mt-2 text-3xl font-semibold tracking-tight text-white sm:text-4xl">{{ $laboratory->name }}</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">{{ $laboratory->description }}</p>
                        <a href="#materi" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-blue-50">
                            Mulai belajar <span aria-hidden="true">↓</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 border-b border-slate-100 p-5 sm:grid-cols-3 sm:p-7">
                @foreach ([
                    ['Materi', $laboratory->materials_count],
                    ['Eksperimen', $laboratory->experiments_count],
                    ['Kuis', $laboratory->quizzes_count],
                ] as [$label, $count])
                    <div class="rounded-xl bg-slate-50 px-4 py-3">
                        <p class="text-xs font-medium text-slate-500">{{ $label }} tersedia</p>
                        <p class="mt-1 text-xl font-semibold text-slate-950">{{ number_format($count) }}</p>
                    </div>
                @endforeach
            </div>

            <section id="materi" class="scroll-mt-24 p-5 sm:p-7">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold tracking-tight text-slate-950">Materi pembelajaran</h2>
                        <p class="mt-1 text-sm text-slate-600">Pilih topik untuk membaca materi dan melanjutkan pembelajaran.</p>
                    </div>
                    <span class="text-xs font-medium text-slate-500">{{ $laboratory->materials_count }} materi</span>
                </div>

                @if ($materials->isEmpty())
                    <div class="mt-5 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center">
                        <span class="mx-auto flex size-11 items-center justify-center rounded-2xl bg-white text-slate-500 shadow-sm">∅</span>
                        <p class="mt-3 text-sm font-semibold text-slate-800">Materi belum tersedia</p>
                        <p class="mt-1 text-sm text-slate-500">Materi resmi akan tampil di sini setelah ditambahkan administrator.</p>
                    </div>
                @else
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        @foreach ($materials as $material)
                            <article class="flex flex-col rounded-2xl border border-slate-200 bg-white p-5">
                                <h3 class="font-semibold text-slate-900">{{ $material->title }}</h3>
                                <p class="mt-2 flex-1 text-sm leading-6 text-slate-600">{{ $material->description ?: 'Pelajari konsep dan istilah penting pada topik ini.' }}</p>
                                <a href="{{ route('materials.show', $material) }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
                                    Mulai belajar <span aria-hidden="true">→</span>
                                </a>
                            </article>
                        @endforeach
                    </div>
                    @if ($materials->hasPages())
                        <div class="mt-5">{{ $materials->links() }}</div>
                    @endif
                @endif
            </section>

            <section class="border-t border-slate-100 p-5 sm:p-7">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold tracking-tight text-slate-950">Panduan eksperimen</h2>
                        <p class="mt-1 text-sm text-slate-600">Buka tujuan dan instruksi sebelum memulai praktikum virtual.</p>
                    </div>
                    <span class="text-xs font-medium text-slate-500">{{ $laboratory->experiments_count }} eksperimen</span>
                </div>

                @if ($experiments->isEmpty())
                    <div class="mt-5 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center">
                        <p class="text-sm font-semibold text-slate-800">Eksperimen belum tersedia</p>
                        <p class="mt-1 text-sm text-slate-500">Panduan praktikum akan tampil di sini setelah ditambahkan administrator.</p>
                    </div>
                @else
                    <div class="mt-5 divide-y divide-slate-100 rounded-2xl border border-slate-200">
                        @foreach ($experiments as $experiment)
                            <article class="flex flex-col gap-4 p-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-slate-900">{{ $experiment->title }}</h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-600">{{ $experiment->description ?: 'Panduan eksperimen virtual' }}</p>
                                    @if ($experiment->material)
                                        <p class="mt-1 text-xs text-slate-500">Materi: {{ $experiment->material->title }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('experiments.show', $experiment) }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-800">
                                    Mulai eksperimen <span aria-hidden="true">→</span>
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
    </section>
@endsection
