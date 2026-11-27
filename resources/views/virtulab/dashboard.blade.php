@extends('layouts.app')

@section('title', $pageTitle ?? 'Katalog Lab 3D')

@section('content')
<section class="vl-welcome-row">
    <div>
        <div class="vl-eyebrow"><span class="vl-eyebrow-line"></span> VIRTUAL SCIENCE LEARNING</div>
        <h1>Selamat datang di <span>VirtuLab.</span></h1>
        <p class="vl-lead">Ruang praktikum digital untuk memahami sains melalui eksplorasi dan eksperimen.</p>
    </div>
    <div class="vl-welcome-art" aria-hidden="true"><div class="vl-orbit orbit-one"></div><div class="vl-orbit orbit-two"></div><div class="vl-art-core"><i class="vl-icon vl-icon-atom"></i></div><span class="vl-art-dot dot-a"></span><span class="vl-art-dot dot-b"></span></div>
</section>

<section class="vl-stat-grid" aria-label="Ringkasan pembelajaran">
    <article class="vl-stat-card"><span class="vl-stat-icon mint"><i class="vl-icon vl-icon-flask"></i></span><div><small>LABORATORIUM</small><strong>03</strong><span>Ruang eksperimen tersedia</span></div></article>
    <article class="vl-stat-card"><span class="vl-stat-icon sand"><i class="vl-icon vl-icon-book"></i></span><div><small>MODUL PEMBELAJARAN</small><strong>03</strong><span>Materi teori dan praktik</span></div></article>
    <article class="vl-stat-card"><span class="vl-stat-icon blue"><i class="vl-icon vl-icon-chart"></i></span><div><small>MODE BELAJAR</small><strong>2</strong><span>Teori & praktik interaktif</span></div></article>
</section>

<section class="vl-section-heading" id="learning-path"><div><div class="vl-eyebrow">PILIH RUANG PRAKTIK</div><h2>Jelajahi laboratorium</h2><p>Pilih topik untuk mempelajari teori dan melakukan eksperimen virtual.</p></div><span class="vl-section-count">03 LABS</span></section>

<section class="vl-lab-grid">
    @foreach($labs as $item)
        <article class="vl-lab-card lab-{{ $item['slug'] }}">
            <div class="vl-lab-card-top"><span class="vl-subject-pill">{{ $item['subject'] }}</span><span class="vl-card-duration"><i class="vl-icon vl-icon-clock"></i>{{ $item['duration'] }}</span></div>
            <div class="vl-lab-illustration illustration-{{ $item['slug'] }}" aria-hidden="true">
                @if($item['slug'] === 'physics')
                    <div class="physics-platform"></div><div class="physics-launcher"></div><div class="physics-ball"></div><div class="physics-target"></div>
                @elseif($item['slug'] === 'chemistry')
                    <div class="chem-bottle bottle-left"><span></span></div><div class="chem-beaker"><span></span></div><div class="chem-bottle bottle-right"><span></span></div>
                @else
                    <div class="circuit-board"><span class="circuit-line"></span><span class="circuit-resistor r-one"></span><span class="circuit-resistor r-two"></span><span class="circuit-bulb"></span></div>
                @endif
            </div>
            <div class="vl-lab-card-body"><div class="vl-card-kicker">{{ $item['eyebrow'] }}</div><h3>{{ $item['name'] }}</h3><p>{{ $item['short'] }}</p><div class="vl-card-footer"><span class="vl-level"><i class="vl-icon vl-icon-signal"></i>{{ $item['level'] }}</span><a href="{{ route('virtulab.lab', $item['slug']) }}" class="vl-arrow-link">Masuk lab <i class="vl-icon vl-icon-arrow"></i></a></div></div>
        </article>
    @endforeach
</section>

<section class="vl-how-panel">
    <div class="vl-how-copy"><div class="vl-eyebrow">LEARNING FLOW</div><h2>Belajar dengan cara yang lebih nyata.</h2><p>Setiap laboratorium dirancang dengan alur sederhana agar konsep yang dipelajari langsung terhubung dengan praktik.</p></div>
    <div class="vl-flow-steps"><div class="vl-flow-step"><span>01</span><strong>Pelajari teori</strong><small>Pahami konsep, rumus, dan tujuan eksperimen.</small></div><i class="vl-icon vl-icon-arrow-right"></i><div class="vl-flow-step"><span>02</span><strong>Lakukan praktik</strong><small>Atur alat dan parameter dalam ruang virtual.</small></div><i class="vl-icon vl-icon-arrow-right"></i><div class="vl-flow-step"><span>03</span><strong>Amati hasil</strong><small>Bandingkan hasil dan tulis kesimpulan.</small></div></div>
</section>
@endsection
