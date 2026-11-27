<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class VirtuLabController extends Controller
{
    /**
     * Demo content for the VirtuLab interface.
     * Replace this array with Eloquent queries when the PostgreSQL schema is ready.
     */
    private array $labs = [
        'physics' => [
            'slug' => 'physics',
            'name' => 'Gerak Parabola',
            'subject' => 'Fisika',
            'eyebrow' => 'PHYSICS LABORATORY',
            'short' => 'Amati bagaimana sudut dan kecepatan awal memengaruhi lintasan proyektil.',
            'duration' => '15–20 menit',
            'level' => 'Menengah',
            'accent' => '#4c9d91',
            'objective' => 'Memahami hubungan antara kecepatan awal, sudut elevasi, gravitasi, dan lintasan benda yang bergerak secara parabola.',
            'theory' => 'Gerak parabola merupakan gabungan gerak lurus beraturan pada sumbu horizontal dan gerak lurus berubah beraturan pada sumbu vertikal. Dalam model ideal, hambatan udara diabaikan sehingga komponen kecepatan horizontal tetap, sedangkan komponen vertikal dipengaruhi gravitasi.',
            'concepts' => [
                ['title' => 'Komponen horizontal', 'body' => 'Kecepatan horizontal bernilai tetap selama hambatan udara diabaikan.'],
                ['title' => 'Komponen vertikal', 'body' => 'Kecepatan vertikal berubah karena percepatan gravitasi yang arahnya ke bawah.'],
                ['title' => 'Titik tertinggi', 'body' => 'Pada titik tertinggi, komponen kecepatan vertikal sesaat bernilai nol.'],
            ],
            'formulas' => [
                ['label' => 'Waktu total', 'value' => 't = 2v₀ sin(θ) / g'],
                ['label' => 'Tinggi maksimum', 'value' => 'h = v₀² sin²(θ) / 2g'],
                ['label' => 'Jarak horizontal', 'value' => 'R = v₀² sin(2θ) / g'],
            ],
            'steps' => ['Atur kecepatan awal pada panel eksperimen.', 'Tentukan sudut elevasi peluncur.', 'Pilih nilai gravitasi yang akan digunakan.', 'Jalankan simulasi dan amati lintasan proyektil.', 'Bandingkan jarak serta tinggi maksimum pada beberapa percobaan.'],
            'safety' => 'Simulasi menggunakan model gerak ideal. Hambatan udara dan bentuk proyektil tidak diperhitungkan.',
        ],
        'chemistry' => [
            'slug' => 'chemistry',
            'name' => 'Reaksi Asam–Basa',
            'subject' => 'Kimia',
            'eyebrow' => 'CHEMISTRY LABORATORY',
            'short' => 'Pelajari reaksi cuka dan natrium bikarbonat melalui pengamatan pembentukan gas.',
            'duration' => '10–15 menit',
            'level' => 'Dasar',
            'accent' => '#6c9da8',
            'objective' => 'Mengidentifikasi pereaksi dan produk reaksi asam–basa serta memahami konsep pereaksi pembatas melalui perubahan jumlah bahan.',
            'theory' => 'Asam asetat dalam cuka bereaksi dengan natrium bikarbonat (soda kue). Reaksi menghasilkan natrium asetat, air, dan gas karbon dioksida. Gelembung yang terlihat pada percobaan merupakan gas karbon dioksida yang terbentuk selama reaksi.',
            'concepts' => [
                ['title' => 'Reaktan', 'body' => 'Cuka mengandung asam asetat, sedangkan soda kue mengandung natrium bikarbonat.'],
                ['title' => 'Produk reaksi', 'body' => 'Reaksi menghasilkan natrium asetat, air, dan karbon dioksida.'],
                ['title' => 'Pereaksi pembatas', 'body' => 'Pereaksi pembatas adalah bahan yang habis lebih dahulu dan membatasi jumlah produk.'],
            ],
            'formulas' => [
                ['label' => 'Persamaan reaksi', 'value' => 'CH₃COOH + NaHCO₃ → CH₃COONa + H₂O + CO₂'],
                ['label' => 'Perbandingan mol', 'value' => '1 mol : 1 mol'],
                ['label' => 'Gas terbentuk', 'value' => 'n(CO₂) = mol pereaksi pembatas'],
            ],
            'steps' => ['Amati beaker dan bahan yang tersedia.', 'Atur volume larutan cuka.', 'Atur massa soda kue yang akan ditambahkan.', 'Masukkan soda kue ke dalam beaker untuk memulai reaksi.', 'Amati gelembung dan bandingkan jumlah gas berdasarkan variasi bahan.'],
            'safety' => 'Ini adalah simulasi pembelajaran, bukan panduan praktikum keselamatan. Hasil gas menggunakan pendekatan stoikiometri ideal dan kondisi ruang asumsi.',
        ],
        'electrical' => [
            'slug' => 'electrical',
            'name' => 'Rangkaian Listrik',
            'subject' => 'Fisika',
            'eyebrow' => 'ELECTRICAL LABORATORY',
            'short' => 'Susun komponen rangkaian seri dan paralel, lalu amati arus dan tegangan.',
            'duration' => '15 menit',
            'level' => 'Dasar–Menengah',
            'accent' => '#c49a61',
            'objective' => 'Membandingkan karakteristik rangkaian seri dan paralel serta memahami hubungan tegangan, arus, hambatan, dan daya listrik.',
            'theory' => 'Rangkaian seri memiliki satu jalur arus sehingga arus yang melewati setiap komponen sama. Rangkaian paralel memiliki lebih dari satu cabang sehingga tegangan pada setiap cabang sama. Hukum Ohm menjelaskan hubungan tegangan, arus, dan hambatan.',
            'concepts' => [
                ['title' => 'Hukum Ohm', 'body' => 'Tegangan sama dengan arus dikalikan hambatan (V = I × R).'],
                ['title' => 'Rangkaian seri', 'body' => 'Hambatan total merupakan jumlah seluruh hambatan komponen.'],
                ['title' => 'Rangkaian paralel', 'body' => 'Kebalikan hambatan total sama dengan jumlah kebalikan hambatan setiap cabang.'],
            ],
            'formulas' => [
                ['label' => 'Hukum Ohm', 'value' => 'V = I × R'],
                ['label' => 'Hambatan seri', 'value' => 'Rₜ = R₁ + R₂'],
                ['label' => 'Hambatan paralel', 'value' => '1/Rₜ = 1/R₁ + 1/R₂'],
            ],
            'steps' => ['Pilih konfigurasi seri atau paralel.', 'Atur tegangan sumber dan nilai resistor.', 'Periksa susunan komponen pada papan rangkaian.', 'Tutup sakelar untuk mengalirkan arus.', 'Bandingkan arus, hambatan total, dan daya pada setiap konfigurasi.'],
            'safety' => 'Simulasi menggunakan rangkaian DC ideal. Hambatan kabel, suhu komponen, dan toleransi resistor tidak diperhitungkan.',
        ],
    ];

    public function index(): View
    {
        return view('virtulab.dashboard', [
            'labs' => $this->labs,
            'pageTitle' => 'Dashboard',
        ]);
    }

    public function show(string $slug): View
    {
        abort_unless(array_key_exists($slug, $this->labs), 404);

        return view('virtulab.lab', [
            'lab' => $this->labs[$slug],
            'labs' => $this->labs,
            'pageTitle' => $this->labs[$slug]['name'],
        ]);
    }
}
