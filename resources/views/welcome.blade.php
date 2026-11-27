@extends('layouts.guest')

@section('title', 'Laboratorium kelas virtual')
@section('meta-description', 'Belajar Fisika, Kimia, dan Biologi lewat pengalaman laboratorium virtual yang interaktif dan aman.')

@section('content')
    <main>
        <section class="relative isolate overflow-hidden bg-slate-950">
            <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_75%_20%,rgba(16,185,129,0.22),transparent_35%),radial-gradient(ellipse_at_15%_90%,rgba(59,130,246,0.14),transparent_35%)]"></div>
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-5 py-20 sm:px-8 sm:py-28 lg:grid-cols-[1.05fr_0.95fr] lg:py-32">
                <div>
                    <p class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/[0.06] px-3.5 py-2 text-xs font-semibold tracking-wide text-emerald-200">
                        <span class="size-2 animate-pulse rounded-full bg-emerald-400"></span>
                        SAINS, DENGAN CARA YANG LEBIH DEKAT
                    </p>
                    <h1 class="mt-7 max-w-3xl text-5xl font-semibold leading-[1.05] tracking-tight text-white sm:text-6xl lg:text-7xl">
                        Rasa ingin tahu adalah <span class="text-emerald-300">awal penemuan.</span>
                    </h1>
                    <p class="mt-6 max-w-xl text-base leading-8 text-slate-300 sm:text-lg">
                        Pilih bidang sains, telusuri katalog laboratorium, dan pantau perjalanan belajarmu dalam satu ruang virtual.
                    </p>
                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-5 py-3.5 text-sm font-bold text-slate-950 transition hover:bg-emerald-300">
                            Mulai belajar
                            <svg viewBox="0 0 20 20" class="size-4" fill="none" aria-hidden="true"><path d="M4.5 10h11m-4.5-4.5L15.5 10 11 14.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                        <a href="#laboratorium" class="inline-flex items-center justify-center rounded-xl border border-white/20 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">Jelajahi laboratorium</a>
                    </div>
                    <div class="mt-10 flex flex-wrap items-center gap-x-6 gap-y-3 text-xs font-medium text-slate-400">
                        <span class="inline-flex items-center gap-2"><span class="size-1.5 rounded-full bg-blue-400"></span>Fisika</span>
                        <span class="inline-flex items-center gap-2"><span class="size-1.5 rounded-full bg-violet-400"></span>Kimia</span>
                        <span class="inline-flex items-center gap-2"><span class="size-1.5 rounded-full bg-emerald-400"></span>Biologi</span>
                        <span class="text-slate-600">·</span>
                        <span>Belajar dengan aman dan fleksibel</span>
                    </div>
                </div>

                <div class="relative mx-auto w-full max-w-lg">
                    <div class="absolute -inset-8 rounded-full bg-emerald-400/10 blur-3xl"></div>
                    <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.06] p-5 shadow-2xl shadow-black/30 backdrop-blur">
                        <div class="flex items-center justify-between border-b border-white/10 pb-4">
                            <div>
                                <p class="text-xs font-medium text-slate-400">RUANG EKSPERIMEN</p>
                                <p class="mt-1 text-sm font-semibold text-white">Laboratorium virtual</p>
                            </div>
                            <span class="rounded-full border border-emerald-300/20 bg-emerald-300/10 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-emerald-200">Siap dijelajahi</span>
                        </div>
                        <div class="relative my-5 flex aspect-[1.15] items-center justify-center overflow-hidden rounded-2xl bg-slate-900">
                            <div class="absolute size-64 rounded-full border border-emerald-300/15"></div>
                            <div class="absolute size-48 rounded-full border border-blue-300/20"></div>
                            <div class="absolute size-32 rounded-full border border-violet-300/25"></div>
                            <div class="absolute size-3 -translate-y-24 rounded-full bg-emerald-300 shadow-[0_0_30px_8px_rgba(110,231,183,0.45)]"></div>
                            <div class="absolute size-2 translate-x-24 rounded-full bg-blue-300 shadow-[0_0_24px_6px_rgba(147,197,253,0.45)]"></div>
                            <div class="absolute size-2 -translate-x-16 translate-y-16 rounded-full bg-violet-300 shadow-[0_0_24px_6px_rgba(196,181,253,0.4)]"></div>
                            <div class="relative flex size-20 items-center justify-center rounded-3xl border border-white/15 bg-white/10 text-emerald-200 shadow-xl backdrop-blur">
                                <svg viewBox="0 0 48 48" class="size-10" fill="none" aria-hidden="true">
                                    <path d="M24 7v9m0 16v9M7 24h9m16 0h9M12 12l6.3 6.3m11.4 11.4L36 36m0-24-6.3 6.3M18.3 29.7 12 36" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <circle cx="24" cy="24" r="7" stroke="currentColor" stroke-width="1.7"/>
                                </svg>
                            </div>
                            <span class="absolute bottom-4 left-4 rounded-lg border border-white/10 bg-slate-950/70 px-3 py-2 text-xs text-slate-300">Amati · Catat · Pahami</span>
                            <span class="absolute right-4 top-4 flex items-center gap-1.5 text-[10px] font-medium text-slate-400"><span class="size-1.5 rounded-full bg-emerald-400"></span> Jelajahi bidang sains</span>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="rounded-xl border border-white/10 bg-white/[0.04] p-3"><p class="text-[10px] font-medium uppercase tracking-wide text-slate-500">Bidang</p><p class="mt-1 text-sm font-semibold text-white">Tiga cabang</p></div>
                            <div class="rounded-xl border border-white/10 bg-white/[0.04] p-3"><p class="text-[10px] font-medium uppercase tracking-wide text-slate-500">Katalog</p><p class="mt-1 text-sm font-semibold text-white">Berbasis data</p></div>
                            <div class="rounded-xl border border-white/10 bg-white/[0.04] p-3"><p class="text-[10px] font-medium uppercase tracking-wide text-slate-500">Belajar</p><p class="mt-1 text-sm font-semibold text-white">Bertahap</p></div>
                        </div>
                    </div>
                    <div class="absolute -right-4 top-16 hidden rounded-2xl border border-white/10 bg-slate-900/90 p-3 shadow-xl sm:block">
                        <div class="flex items-center gap-2"><span class="flex size-8 items-center justify-center rounded-xl bg-blue-400/10 text-blue-200">+</span><span class="text-xs font-semibold text-white">Eksperimen dimulai<br><span class="font-normal text-slate-400">dengan rasa ingin tahu</span></span></div>
                    </div>
                </div>
            </div>
        </section>

        <section id="laboratorium" class="scroll-mt-24 py-20 sm:py-24">
            <div class="mx-auto max-w-7xl px-5 sm:px-8">
                <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                    <div class="max-w-2xl">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">Tiga bidang, banyak kemungkinan</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Pilih laboratoriummu</h2>
                        <p class="mt-3 text-base leading-7 text-slate-600">Setiap bidang punya cara unik untuk mengajukan pertanyaan, menguji gagasan, dan memahami dunia.</p>
                    </div>
                    <p class="text-sm text-slate-500">Katalog laboratorium tersimpan di database.</p>
                </div>

                <div class="mt-10 grid gap-5 md:grid-cols-3">
                    @forelse ($laboratories as $laboratory)
                        @php
                            $theme = match ($laboratory->slug) {
                                'fisika' => ['icon' => '∿', 'number' => '01', 'classes' => 'bg-blue-50 text-blue-700 border-blue-100', 'tint' => 'bg-blue-500/5'],
                                'kimia' => ['icon' => '⌬', 'number' => '02', 'classes' => 'bg-violet-50 text-violet-700 border-violet-100', 'tint' => 'bg-violet-500/5'],
                                default => ['icon' => '✳', 'number' => '03', 'classes' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'tint' => 'bg-emerald-500/5'],
                            };
                        @endphp
                        <article class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-900/[0.06] sm:p-7">
                            <div class="absolute right-0 top-0 h-28 w-28 rounded-bl-full {{ $theme['tint'] }} transition group-hover:scale-125"></div>
                            <div class="relative flex items-center justify-between">
                                <span class="flex size-14 items-center justify-center rounded-2xl border text-2xl font-semibold {{ $theme['classes'] }}">{{ $theme['icon'] }}</span>
                                <span class="text-xs font-bold tracking-[0.18em] text-slate-300">{{ $theme['number'] }}</span>
                            </div>
                            <h3 class="relative mt-6 text-xl font-semibold tracking-tight text-slate-950">{{ $laboratory->name }}</h3>
                            <p class="relative mt-3 min-h-20 text-sm leading-6 text-slate-600">{{ $laboratory->description }}</p>
                            <a href="{{ route('laboratories.show', $laboratory->slug) }}" class="relative mt-6 inline-flex items-center gap-2 text-sm font-bold text-slate-800 transition group-hover:text-emerald-700">
                                Lihat laboratorium
                                <svg viewBox="0 0 20 20" class="size-4 transition group-hover:translate-x-1" fill="none" aria-hidden="true"><path d="M4.5 10h11m-4.5-4.5L15.5 10 11 14.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </article>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-sm text-slate-600 md:col-span-3">
                            Katalog laboratorium belum tersedia. Jalankan seeder katalog untuk menyiapkan bidang pembelajaran.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="tentang" class="border-y border-slate-200 bg-white py-20 sm:py-24">
            <div class="mx-auto grid max-w-7xl gap-12 px-5 sm:px-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">Belajar dengan melakukan</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Bukan sekadar membaca teori.</h2>
                    <p class="mt-4 leading-7 text-slate-600">Virtual Laboratory membantu siswa memahami konsep melalui materi, langkah praktikum, simulasi, dan refleksi yang saling terhubung.</p>
                    <a href="{{ route('register') }}" class="mt-7 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">Buat akun siswa <span aria-hidden="true">→</span></a>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <article class="rounded-2xl border border-slate-200 bg-[#f7f8f5] p-5">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800">
                            <svg viewBox="0 0 24 24" class="size-5" fill="none" aria-hidden="true"><path d="M5 5.5A2.5 2.5 0 0 1 7.5 3H20v16H7.5A2.5 2.5 0 0 0 5 21.5v-16ZM5 18.5A2.5 2.5 0 0 1 7.5 16H20" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        </span>
                        <h3 class="mt-4 font-semibold text-slate-900">Katalog sains</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Temukan bidang Fisika, Kimia, dan Biologi yang tersedia di database.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 bg-[#f7f8f5] p-5">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-blue-100 text-blue-800">
                            <svg viewBox="0 0 24 24" class="size-5" fill="none" aria-hidden="true"><path d="M4 17.5 9 12l3.5 3.5L20 7m0 0h-5m5 0v5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        <h3 class="mt-4 font-semibold text-slate-900">Ruang praktikum</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Fondasi aplikasi disiapkan untuk menghubungkan panduan, simulasi, dan hasil belajar.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 bg-[#f7f8f5] p-5">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-violet-100 text-violet-800">
                            <svg viewBox="0 0 24 24" class="size-5" fill="none" aria-hidden="true"><path d="M12 3.5 19 6v5.5c0 4.3-2.9 7.4-7 9-4.1-1.6-7-4.7-7-9V6l7-2.5Z" stroke="currentColor" stroke-width="1.6"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        <h3 class="mt-4 font-semibold text-slate-900">Aman dan fleksibel</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Modul sains dirancang untuk pembelajaran virtual yang edukatif dan aman.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 bg-[#f7f8f5] p-5">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-amber-100 text-amber-800">
                            <svg viewBox="0 0 24 24" class="size-5" fill="none" aria-hidden="true"><path d="M5 19V9m7 10V5m7 14v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M3 19.5h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </span>
                        <h3 class="mt-4 font-semibold text-slate-900">Progres tercatat</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Dashboard menampilkan progres yang tercatat untuk akun masing-masing.</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="cara-belajar" class="py-20 sm:py-24">
            <div class="mx-auto max-w-7xl px-5 sm:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">Mulai dalam tiga langkah</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Alur belajar yang jelas</h2>
                </div>
                <div class="mt-12 grid gap-5 md:grid-cols-3">
                    @foreach ([['01', 'Pilih bidang', 'Jelajahi laboratorium yang sesuai dengan pertanyaanmu.'], ['02', 'Pelajari dan amati', 'Ikuti materi dan panduan eksperimen secara bertahap.'], ['03', 'Catat kesimpulan', 'Simpan pengamatan dan tinjau kembali hasil belajarmu.']] as [$number, $title, $description])
                        <article class="rounded-2xl border border-slate-200 bg-white p-6">
                            <span class="text-sm font-bold tracking-[0.16em] text-emerald-700">{{ $number }}</span>
                            <h3 class="mt-4 text-lg font-semibold text-slate-950">{{ $title }}</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $description }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="px-5 pb-20 sm:px-8 sm:pb-24">
            <div class="mx-auto max-w-7xl overflow-hidden rounded-3xl bg-emerald-600 px-6 py-12 text-center sm:px-12 sm:py-16">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-100">Laboratorium kelas virtual</p>
                <h2 class="mx-auto mt-3 max-w-2xl text-3xl font-semibold tracking-tight text-white sm:text-4xl">Pertanyaan sainsmu layak untuk dijelajahi.</h2>
                <p class="mx-auto mt-4 max-w-xl text-sm leading-6 text-emerald-50 sm:text-base">Buat akun siswa dan mulai bangun kebiasaan belajar dengan eksperimen.</p>
                <a href="{{ route('register') }}" class="mt-7 inline-flex items-center justify-center rounded-xl bg-white px-5 py-3 text-sm font-bold text-emerald-800 transition hover:bg-emerald-50">Daftar gratis</a>
            </div>
        </section>
    </main>
@endsection
