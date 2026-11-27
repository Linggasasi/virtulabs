@extends('layouts.app')

@section('title', $experiment->title)

@section('content')
    <article class="mx-auto max-w-4xl">
        <a href="{{ route('laboratories.show', $experiment->laboratory->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-700">
            <span aria-hidden="true">←</span> {{ $experiment->laboratory->name }}
        </a>

        <header class="mt-6 rounded-3xl bg-slate-950 px-6 py-8 sm:px-10 sm:py-10">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-300">Panduan eksperimen · {{ $experiment->laboratory->name }}</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight text-white sm:text-4xl">{{ $experiment->title }}</h1>
            @if ($experiment->description)
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300 sm:text-base">{{ $experiment->description }}</p>
            @endif
            @if ($experiment->material)
                <a href="{{ route('materials.show', $experiment->material) }}" class="mt-5 inline-flex items-center gap-2 rounded-xl border border-white/20 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10">
                    Baca materi: {{ $experiment->material->title }} <span aria-hidden="true">→</span>
                </a>
            @endif
        </header>

        @if ($experiment->objectives)
            <section class="mt-6 rounded-2xl border border-blue-100 bg-blue-50/70 p-6 sm:p-8">
                <h2 class="font-semibold text-blue-950">Tujuan eksperimen</h2>
                <p class="mt-3 whitespace-pre-line text-sm leading-7 text-blue-950/80">{{ $experiment->objectives }}</p>
            </section>
        @endif

        <section class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 sm:p-9">
            <h2 class="text-lg font-semibold text-slate-950">Langkah dan instruksi</h2>
            @if ($experiment->instructions)
                <div class="mt-5 whitespace-pre-line text-sm leading-7 text-slate-700 sm:text-base">{{ $experiment->instructions }}</div>
            @else
                <p class="mt-3 text-sm leading-6 text-slate-500">Panduan langkah eksperimen belum ditambahkan.</p>
            @endif
        </section>

        @if (! $experiment->objectives && ! $experiment->instructions)
            <p class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900" role="status">
                Panduan ini masih disiapkan. Kembali ke laboratorium untuk memilih materi lain.
            </p>
        @endif
    </article>
@endsection
