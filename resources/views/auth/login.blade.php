@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <main class="mx-auto grid min-h-[calc(100vh-10rem)] max-w-6xl items-center gap-12 px-5 py-12 sm:px-8 lg:grid-cols-[1fr_0.85fr]">
        <section class="hidden lg:block">
            <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-emerald-800">
                <span class="size-1.5 rounded-full bg-emerald-500"></span>
                Ruang belajar sains
            </p>
            <h1 class="max-w-xl text-5xl font-semibold leading-[1.08] tracking-tight text-slate-950">Lanjutkan rasa ingin tahumu.</h1>
            <p class="mt-5 max-w-lg text-lg leading-8 text-slate-600">Masuk untuk melihat praktikum, mencatat pengamatan, dan melanjutkan progres belajarmu.</p>
            <div class="mt-10 flex items-center gap-3 text-sm font-medium text-slate-500">
                <span class="flex size-9 items-center justify-center rounded-xl bg-blue-50 text-blue-700">01</span>
                Fisika
                <span class="mx-1 text-slate-300">/</span>
                <span class="flex size-9 items-center justify-center rounded-xl bg-violet-50 text-violet-700">02</span>
                Kimia
                <span class="mx-1 text-slate-300">/</span>
                <span class="flex size-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">03</span>
                Biologi
            </div>
        </section>

        <section class="mx-auto w-full max-w-md rounded-3xl border border-slate-200 bg-white p-7 shadow-xl shadow-slate-900/[0.04] sm:p-9">
            <div class="mb-8">
                <p class="text-sm font-semibold text-emerald-700">Selamat datang kembali</p>
                <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Masuk ke akun</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">Gunakan email dan password yang terdaftar.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800" role="alert">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="nama@email.com" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                    @error('email')
                        <p id="email-error" class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="Masukkan password">
                </div>
                <label for="remember" class="flex items-center gap-2 text-sm text-slate-600">
                    <input id="remember" name="remember" type="checkbox" value="1" class="size-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    Ingat saya di perangkat ini
                </label>
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3.5 text-sm font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-500/20">
                    Masuk
                    <svg viewBox="0 0 20 20" class="size-4" fill="none" aria-hidden="true"><path d="M4.5 10h11m-4.5-4.5L15.5 10 11 14.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </form>
            <p class="mt-7 text-center text-sm text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Daftar sebagai siswa</a></p>
        </section>
    </main>
@endsection
