@extends('layouts.app')

@section('title', $pageTitle ?? $lab['name'])

@section('content')
<div class="vl-lab-page" data-lab="{{ $lab['slug'] }}" id="virtulabLab">
    <div class="vl-lab-heading">
        <div>
            <a class="vl-back-link" href="{{ route('virtulab.index') }}"><i class="vl-icon vl-icon-arrow-left"></i> Semua laboratorium</a>
            <div class="vl-eyebrow"><span class="vl-eyebrow-line"></span>{{ $lab['eyebrow'] }}</div>
            <h1>{{ $lab['name'] }}</h1>
            <p class="vl-lead">{{ $lab['short'] }}</p>
        </div>
        <div class="vl-lab-meta"><span><i class="vl-icon vl-icon-clock"></i>{{ $lab['duration'] }}</span><span><i class="vl-icon vl-icon-signal"></i>{{ $lab['level'] }}</span></div>
    </div>

    <div class="vl-mode-tabs" role="tablist" aria-label="Mode pembelajaran">
        <button class="vl-mode-tab is-active" data-mode="theory" role="tab" aria-selected="true"><i class="vl-icon vl-icon-book"></i><span><strong>01 · TEORI</strong><small>Pelajari konsep dasar</small></span></button>
        <div class="vl-tab-connector"></div>
        <button class="vl-mode-tab" data-mode="practice" role="tab" aria-selected="false"><i class="vl-icon vl-icon-lab"></i><span><strong>02 · PRAKTIK</strong><small>Lakukan eksperimen</small></span></button>
    </div>

    <section class="vl-mode-panel is-active" data-panel="theory" role="tabpanel">
        <div class="vl-theory-layout">
            <article class="vl-theory-main">
                <div class="vl-content-kicker">PENGANTAR MATERI</div>
                <h2>Memahami {{ strtolower($lab['name']) }}</h2>
                <p class="vl-theory-intro">{{ $lab['theory'] }}</p>
                <div class="vl-objective-box"><span class="vl-objective-icon"><i class="vl-icon vl-icon-target"></i></span><div><strong>Tujuan pembelajaran</strong><p>{{ $lab['objective'] }}</p></div></div>
                <h3>Konsep penting</h3>
                <div class="vl-concept-list">
                    @foreach($lab['concepts'] as $index => $concept)
                        <div class="vl-concept-item"><span class="vl-concept-number">0{{ $index + 1 }}</span><div><strong>{{ $concept['title'] }}</strong><p>{{ $concept['body'] }}</p></div></div>
                    @endforeach
                </div>
            </article>
            <aside class="vl-theory-aside">
                <div class="vl-formula-card"><div class="vl-aside-heading"><span class="vl-aside-icon"><i class="vl-icon vl-icon-function"></i></span><span><strong>Rumus & persamaan</strong><small>Referensi eksperimen</small></span></div>
                    @foreach($lab['formulas'] as $formula)
                        <div class="vl-formula-row"><small>{{ $formula['label'] }}</small><strong>{{ $formula['value'] }}</strong></div>
                    @endforeach
                </div>
                <div class="vl-info-card"><i class="vl-icon vl-icon-lightbulb"></i><div><strong>Siap untuk praktik?</strong><p>Setelah memahami konsep, lanjutkan ke ruang praktik untuk mencoba eksperimen secara langsung.</p><button class="vl-button vl-button-primary vl-full" data-go-practice>Masuk ruang praktik <i class="vl-icon vl-icon-arrow-right"></i></button></div></div>
            </aside>
        </div>
    </section>

    <section class="vl-mode-panel" data-panel="practice" role="tabpanel" hidden>
        <div class="vl-practice-intro"><div><div class="vl-content-kicker">VIRTUAL EXPERIMENT ROOM</div><h2>Ruang praktik {{ strtolower($lab['subject']) }}</h2><p>Interaksikan peralatan, ubah parameter, lalu jalankan eksperimen untuk mengamati hasilnya.</p></div><span class="vl-practice-status"><i></i> SIMULASI SIAP</span></div>
        <div class="vl-practice-layout">
            <section class="vl-scene-card">
                <div class="vl-scene-toolbar"><div><span class="vl-scene-live-dot"></span><strong>WORKBENCH · {{ strtoupper($lab['slug']) }}</strong></div><div class="vl-scene-tools"><button type="button" data-camera="reset" title="Reset kamera"><i class="vl-icon vl-icon-focus"></i></button><button type="button" data-camera="zoom-in" title="Perbesar"><i class="vl-icon vl-icon-plus"></i></button><button type="button" data-camera="zoom-out" title="Perkecil"><i class="vl-icon vl-icon-minus"></i></button></div></div>
                <div class="vl-scene-viewport" id="vlSceneViewport" data-lab="{{ $lab['slug'] }}">
                    <div class="vl-scene-loading" id="vlSceneLoading"><span class="vl-loader"></span><strong>Menyiapkan ruang praktik</strong><small>Memuat objek dan peralatan laboratorium…</small></div>
                    <div class="vl-scene-hint"><i class="vl-icon vl-icon-mouse"></i> Drag untuk memutar · Scroll untuk zoom · Klik objek untuk memilih</div>
                    <div class="vl-scene-label" id="vlSceneLabel">{{ strtoupper($lab['subject']) }} · VIRTUAL WORKBENCH</div>
                </div>
                <div class="vl-scene-caption"><span><i class="vl-icon vl-icon-info"></i> Model visual 3D interaktif untuk pembelajaran</span><span id="vlSelectedObject">Belum ada objek dipilih</span></div>
            </section>

            <aside class="vl-control-card">
                <div class="vl-control-head"><span class="vl-control-icon"><i class="vl-icon vl-icon-sliders"></i></span><div><strong>Panel eksperimen</strong><small>Atur variabel percobaan</small></div></div>

                @if($lab['slug'] === 'physics')
                    <div class="vl-control-group"><label for="physicsSpeed">Kecepatan awal <output id="physicsSpeedValue">18 m/s</output></label><input type="range" min="5" max="30" step="1" value="18" id="physicsSpeed" data-param="speed"><div class="vl-range-labels"><span>5 m/s</span><span>30 m/s</span></div></div>
                    <div class="vl-control-group"><label for="physicsAngle">Sudut elevasi <output id="physicsAngleValue">45°</output></label><input type="range" min="10" max="80" step="1" value="45" id="physicsAngle" data-param="angle"><div class="vl-range-labels"><span>10°</span><span>80°</span></div></div>
                    <div class="vl-control-group"><label for="physicsGravity">Gravitasi</label><select id="physicsGravity" data-param="gravity"><option value="9.81">Bumi · 9,81 m/s²</option><option value="1.62">Bulan · 1,62 m/s²</option><option value="3.71">Mars · 3,71 m/s²</option></select></div>
                    <div class="vl-equipment-tip"><i class="vl-icon vl-icon-hand"></i><p><strong>Interaksi alat</strong>Geser kenop sudut di peluncur 3D atau atur menggunakan panel ini.</p></div>
                    <button class="vl-button vl-button-primary vl-full" id="runPhysics"><i class="vl-icon vl-icon-play"></i> Jalankan peluncuran</button>
                    <button class="vl-button vl-button-soft vl-full" id="resetExperiment">Reset percobaan</button>
                @elseif($lab['slug'] === 'chemistry')
                    <div class="vl-control-group"><label for="vinegarVolume">Volume cuka <output id="vinegarValue">30 mL</output></label><input type="range" min="10" max="100" step="5" value="30" id="vinegarVolume" data-param="vinegar"><div class="vl-range-labels"><span>10 mL</span><span>100 mL</span></div></div>
                    <div class="vl-control-group"><label for="bakingSoda">Massa soda kue <output id="sodaValue">1 g</output></label><input type="range" min="0.5" max="8" step="0.5" value="1" id="bakingSoda" data-param="soda"><div class="vl-range-labels"><span>0,5 g</span><span>8 g</span></div></div>
                    <div class="vl-material-actions"><span class="vl-material-label">TAMBAHKAN BAHAN</span><div><button type="button" class="vl-material-button" id="addVinegar"><span class="vl-material-swatch vinegar-swatch"></span><span><strong>Cuka</strong><small>Tuang ke beaker</small></span><i class="vl-icon vl-icon-plus"></i></button><button type="button" class="vl-material-button" id="addSoda"><span class="vl-material-swatch soda-swatch"></span><span><strong>Soda kue</strong><small>Tambahkan serbuk</small></span><i class="vl-icon vl-icon-plus"></i></button></div></div>
                    <button class="vl-button vl-button-primary vl-full" id="runChemistry"><i class="vl-icon vl-icon-flask"></i> Mulai reaksi</button>
                    <button class="vl-button vl-button-soft vl-full" id="resetExperiment">Bersihkan beaker</button>
                @else
                    <div class="vl-control-group"><label for="circuitVoltage">Tegangan sumber <output id="voltageValue">9 V</output></label><input type="range" min="3" max="24" step="1" value="9" id="circuitVoltage" data-param="voltage"><div class="vl-range-labels"><span>3 V</span><span>24 V</span></div></div>
                    <div class="vl-control-group"><label for="resistorOne">Resistor R1 <output id="resistorOneValue">100 Ω</output></label><input type="range" min="10" max="1000" step="10" value="100" id="resistorOne" data-param="r1"></div>
                    <div class="vl-control-group"><label for="resistorTwo">Resistor R2 <output id="resistorTwoValue">220 Ω</output></label><input type="range" min="10" max="1000" step="10" value="220" id="resistorTwo" data-param="r2"></div>
                    <div class="vl-control-group"><label for="circuitType">Konfigurasi rangkaian</label><div class="vl-segmented"><button type="button" class="is-active" data-circuit="series">Seri</button><button type="button" data-circuit="parallel">Paralel</button></div></div>
                    <div class="vl-equipment-tip"><i class="vl-icon vl-icon-hand"></i><p><strong>Interaksi alat</strong>Klik resistor pada papan untuk memilih. Gunakan panel untuk mengubah nilainya.</p></div>
                    <button class="vl-button vl-button-primary vl-full" id="runCircuit"><i class="vl-icon vl-icon-power"></i> Tutup sakelar</button>
                    <button class="vl-button vl-button-soft vl-full" id="resetExperiment">Reset rangkaian</button>
                @endif
                <div class="vl-control-foot"><i class="vl-icon vl-icon-shield"></i> Simulasi edukatif · Bukan pengganti praktikum fisik</div>
            </aside>
        </div>

        <section class="vl-results-section"><div class="vl-results-heading"><div><div class="vl-content-kicker">LIVE OBSERVATION</div><h3>Hasil pengamatan</h3></div><span class="vl-results-updated" id="vlResultState">Menunggu eksperimen</span></div><div class="vl-result-grid" id="vlResultGrid"><div class="vl-result-card"><small>STATUS</small><strong>Siap</strong><span>Atur parameter untuk memulai.</span></div><div class="vl-result-card"><small>DATA</small><strong>—</strong><span>Hasil akan muncul di sini.</span></div><div class="vl-result-card"><small>CATATAN</small><strong>0</strong><span>Eksperimen dijalankan.</span></div></div></section>

        <section class="vl-worksheet"><div class="vl-worksheet-heading"><span class="vl-worksheet-icon"><i class="vl-icon vl-icon-notebook"></i></span><div><h3>Lembar kerja eksperimen</h3><p>Catat prediksi dan kesimpulan berdasarkan hasil pengamatan.</p></div></div><div class="vl-worksheet-fields"><label>Prediksi awal<textarea id="experimentPrediction" rows="3" placeholder="Apa yang kamu perkirakan akan terjadi jika variabel diubah?"></textarea></label><label>Kesimpulan<textarea id="experimentConclusion" rows="3" placeholder="Tuliskan hasil pengamatan dan kesimpulanmu setelah eksperimen."></textarea></label></div><div class="vl-worksheet-actions"><span class="vl-save-status" id="worksheetStatus">Catatan tersimpan lokal di browser.</span><button class="vl-button vl-button-outline" id="saveWorksheet"><i class="vl-icon vl-icon-save"></i> Simpan catatan</button></div></section>
        <p class="vl-safety-note"><i class="vl-icon vl-icon-info"></i>{{ $lab['safety'] }}</p>
    </section>
</div>

<script type="application/json" id="vlLabData">@json($lab)</script>
@endsection
