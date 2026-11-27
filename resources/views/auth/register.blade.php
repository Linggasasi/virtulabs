@extends('layouts.guest')

@section('title', 'Daftar siswa')

@section('content')
    <main class="mx-auto grid min-h-[calc(100vh-10rem)] max-w-6xl items-center gap-12 px-5 py-12 sm:px-8 lg:grid-cols-[1fr_0.85fr]">
        <section class="hidden lg:block">
            <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-emerald-800">
                <span class="size-1.5 rounded-full bg-emerald-500"></span>
                Mulai eksplorasi
            </p>
            <h1 class="max-w-xl text-5xl font-semibold leading-[1.08] tracking-tight text-slate-950">Sains lebih seru saat kamu ikut mencoba.</h1>
            <p class="mt-5 max-w-lg text-lg leading-8 text-slate-600">Buat akun siswa untuk menjelajahi laboratorium, menyimpan hasil praktikum, dan memantau perjalanan belajarmu.</p>
            <div class="mt-9 grid max-w-md grid-cols-3 gap-3">
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4"><span class="text-xs font-bold uppercase tracking-wider text-blue-700">01</span><p class="mt-2 text-sm font-semibold text-slate-800">Fisika</p></div>
                <div class="rounded-2xl border border-violet-100 bg-violet-50 p-4"><span class="text-xs font-bold uppercase tracking-wider text-violet-700">02</span><p class="mt-2 text-sm font-semibold text-slate-800">Kimia</p></div>
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4"><span class="text-xs font-bold uppercase tracking-wider text-emerald-700">03</span><p class="mt-2 text-sm font-semibold text-slate-800">Biologi</p></div>
            </div>
        </section>

        <section class="mx-auto w-full max-w-md rounded-3xl border border-slate-200 bg-white p-7 shadow-xl shadow-slate-900/[0.04] sm:p-9">
            <div class="mb-7">
                <p class="text-sm font-semibold text-emerald-700">Akun belajar baru</p>
                <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Daftar siswa</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">Isi data berikut untuk memulai. Akun baru otomatis mendapat akses siswa.</p>
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

            <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="Nama kamu">
                    @error('name')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="nama@email.com">
                    @error('email')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="Minimal 8 karakter">
                    @error('password')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        placeholder="Ulangi password">
                </div>
                <button type="submit" class="mt-2 flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3.5 text-sm font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-500/20">
                    Buat akun siswa
                    <svg viewBox="0 0 20 20" class="size-4" fill="none" aria-hidden="true"><path d="M4.5 10h11m-4.5-4.5L15.5 10 11 14.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </form>
            <p class="mt-6 text-center text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Masuk</a></p>
        </section>
    </main>
@endsection
