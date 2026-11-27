@extends('layouts.app')

@section('title', $experiment->title)

@section('content')
    @php
        $simSlug = match ($experiment->laboratory->slug) {
            'fisika' => 'physics',
            'kimia' => 'chemistry',
            default => null,
        };
    @endphp

    <div class="vl-lab-heading">
        <div>
            <a class="vl-back-link" href="{{ route('laboratories.show', $experiment->laboratory->slug) }}">
                <i class="vl-icon vl-icon-arrow-left"></i> {{ $experiment->laboratory->name }}
            </a>
            <div class="vl-eyebrow"><span class="vl-eyebrow-line"></span>PANDUAN EKSPERIMEN · {{ strtoupper($experiment->laboratory->slug) }}</div>
            <h1>{{ $experiment->title }}</h1>
            @if ($experiment->description)
                <p class="vl-lead">{{ $experiment->description }}</p>
            @endif
        </div>
    </div>

    <div class="vl-theory-layout">
        <article class="vl-theory-main">
            <div class="vl-content-kicker">INSTRUKSI PRAKTIKUM</div>
            <h2>Langkah dan instruksi</h2>

            @if ($experiment->objectives)
                <div class="vl-objective-box">
                    <span class="vl-objective-icon"><i class="vl-icon vl-icon-target"></i></span>
                    <div>
                        <strong>Tujuan eksperimen</strong>
                        <p class="whitespace-pre-line">{{ $experiment->objectives }}</p>
                    </div>
                </div>
            @endif

            @if ($experiment->instructions)
                <div class="vl-theory-intro whitespace-pre-line">{{ $experiment->instructions }}</div>
            @else
                <p class="mt-3 text-sm text-[#7d9294]">Panduan langkah eksperimen belum ditambahkan.</p>
            @endif

            @if (! $experiment->objectives && ! $experiment->instructions)
                <p class="mt-5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900" role="status">
                    Panduan ini masih disiapkan. Kembali ke laboratorium untuk memilih materi lain.
                </p>
            @endif
        </article>

        <aside class="vl-theory-aside">
            @if ($experiment->material)
                <div class="vl-formula-card">
                    <div class="vl-aside-heading">
                        <span class="vl-aside-icon"><i class="vl-icon vl-icon-book"></i></span>
                        <span><strong>Materi pendukung</strong><small>Referensi teori</small></span>
                    </div>
                    <div class="vl-formula-row">
                        <small>Pelajari konsep sebelum praktik</small>
                        <a href="{{ route('materials.show', $experiment->material) }}" class="vl-arrow-link mt-1">
                            Baca materi: {{ $experiment->material->title }} <i class="vl-icon vl-icon-arrow"></i>
                        </a>
                    </div>
                </div>
            @endif

            <div class="vl-info-card">
                <i class="vl-icon vl-icon-lab"></i>
                <div>
                    <strong>Simulasi 3D Interaktif</strong>
                    <p>Coba langsung ruang praktik virtual 3D untuk mengamati eksperimen secara visual.</p>
                    <a href="{{ $simSlug ? route('virtulab.lab', $simSlug) : route('virtulab.index') }}" class="vl-button vl-button-primary vl-full">
                        Buka ruang praktik 3D <i class="vl-icon vl-icon-arrow-right"></i>
                    </a>
                </div>
            </div>
        </aside>
    </div>
@endsection
