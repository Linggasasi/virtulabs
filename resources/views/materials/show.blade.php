@extends('layouts.app')

@section('title', $material->title)

@section('content')
    <div class="vl-lab-heading">
        <div>
            <a class="vl-back-link" href="{{ route('laboratories.show', $material->laboratory->slug) }}">
                <i class="vl-icon vl-icon-arrow-left"></i> {{ $material->laboratory->name }}
            </a>
            <div class="vl-eyebrow"><span class="vl-eyebrow-line"></span>MATERI PEMBELAJARAN · {{ strtoupper($material->laboratory->slug) }}</div>
            <h1>{{ $material->title }}</h1>
            @if ($material->description)
                <p class="vl-lead">{{ $material->description }}</p>
            @endif
        </div>
    </div>

    <div class="vl-theory-layout">
        <article class="vl-theory-main" aria-labelledby="isi-materi">
            <div class="vl-content-kicker">PENGANTAR MATERI</div>
            <h2 id="isi-materi">Isi materi</h2>
            <div class="vl-theory-intro whitespace-pre-line">{{ $material->content }}</div>
        </article>

        <aside class="vl-theory-aside">
            <div class="vl-formula-card">
                <div class="vl-aside-heading">
                    <span class="vl-aside-icon"><i class="vl-icon vl-icon-lab"></i></span>
                    <span><strong>Eksperimen terkait</strong><small>Lanjutkan ke praktik</small></span>
                </div>

                @forelse ($material->experiments as $experiment)
                    <div class="vl-formula-row">
                        <small>{{ $experiment->description ?: 'Panduan eksperimen' }}</small>
                        <a href="{{ route('experiments.show', $experiment) }}" class="vl-arrow-link mt-1">
                            {{ $experiment->title }} <i class="vl-icon vl-icon-arrow"></i>
                        </a>
                    </div>
                @empty
                    <div class="vl-formula-row">
                        <small>Belum ada eksperimen yang dihubungkan dengan materi ini.</small>
                    </div>
                @endforelse
            </div>

            <div class="vl-info-card">
                <i class="vl-icon vl-icon-lightbulb"></i>
                <div>
                    <strong>Semua topik</strong>
                    <p>Kembali ke daftar materi dan eksperimen di {{ $material->laboratory->name }}.</p>
                    <a href="{{ route('laboratories.show', $material->laboratory->slug) }}" class="vl-button vl-button-outline vl-full">
                        Lihat laboratorium <i class="vl-icon vl-icon-arrow-right"></i>
                    </a>
                </div>
            </div>
        </aside>
    </div>
@endsection
