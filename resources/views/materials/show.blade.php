@extends('layouts.app')

@section('title', $material->title)

@section('content')
    <article class="mx-auto max-w-4xl">
        <a href="{{ route('laboratories.show', $material->laboratory->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-700">
            <span aria-hidden="true">←</span> {{ $material->laboratory->name }}
        </a>

        <header class="mt-6 rounded-3xl bg-slate-950 px-6 py-8 sm:px-10 sm:py-10">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-300">Materi pembelajaran · {{ $material->laboratory->name }}</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight text-white sm:text-4xl">{{ $material->title }}</h1>
            @if ($material->description)
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300 sm:text-base">{{ $material->description }}</p>
            @endif
        </header>

        <section class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 sm:p-9" aria-labelledby="isi-materi">
            <h2 id="isi-materi" class="text-lg font-semibold text-slate-950">Isi materi</h2>
            <div class="mt-5 whitespace-pre-line text-sm leading-7 text-slate-700 sm:text-base">{{ $material->content }}</div>
        </section>

        <section class="mt-8">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-700">Lanjutkan belajar</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-950">Eksperimen terkait</h2>
                </div>
                <a href="{{ route('laboratories.show', $material->laboratory->slug) }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Semua topik →</a>
            </div>

            @forelse ($material->experiments as $experiment)
                <a href="{{ route('experiments.show', $experiment) }}" class="mt-4 flex items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-5 transition hover:border-blue-300 hover:shadow-sm">
                    <div class="min-w-0">
                        <h3 class="truncate font-semibold text-slate-900">{{ $experiment->title }}</h3>
                        @if ($experiment->description)
                            <p class="mt-1 truncate text-sm text-slate-500">{{ $experiment->description }}</p>
                        @endif
                    </div>
                    <span class="shrink-0 text-sm font-semibold text-blue-700">Buka panduan →</span>
                </a>
            @empty
                <div class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-sm text-slate-500">
                    Belum ada eksperimen yang dihubungkan dengan materi ini.
                </div>
            @endforelse
        </section>
    </article>
@endsection
