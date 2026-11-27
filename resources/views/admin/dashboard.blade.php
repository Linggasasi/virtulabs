@extends('layouts.admin')

@section('title', 'Dashboard administrator')

@section('admin-content')
    <section class="space-y-8">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-blue-700">Ruang administrator</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Ringkasan platform</h1>
                <p class="mt-2 text-sm text-slate-600">Pantau aktivitas laboratorium dan kelola konten pembelajaran.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                Kelola pengguna <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ([
                ['Siswa terdaftar', $statistics['students'], 'Akun dengan role siswa', 'bg-blue-50 text-blue-700'],
                ['Administrator', $statistics['administrators'], 'Akun pengelola sistem', 'bg-slate-100 text-slate-700'],
                ['Laboratorium', $statistics['laboratories'], 'Bidang pembelajaran tersedia', 'bg-emerald-50 text-emerald-700'],
                ['Materi', $statistics['materials'], 'Materi tersimpan di database', 'bg-violet-50 text-violet-700'],
                ['Eksperimen', $statistics['experiments'], 'Praktikum yang tersedia', 'bg-amber-50 text-amber-700'],
                ['Kuis', $statistics['quizzes'], 'Evaluasi yang tersedia', 'bg-cyan-50 text-cyan-700'],
                ['Praktikum selesai', $statistics['completedExperiments'], 'Hasil berstatus selesai', 'bg-rose-50 text-rose-700'],
            ] as [$label, $value, $description, $classes])
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/[0.02]">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                            <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">{{ number_format($value) }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $description }}</p>
                        </div>
                        <span class="flex size-10 items-center justify-center rounded-xl text-sm font-bold {{ $classes }}">↗</span>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <div class="border-b border-slate-100 px-5 py-4">
                    <h2 class="font-semibold text-slate-950">Aktivitas laboratorium</h2>
                    <p class="mt-1 text-xs text-slate-500">Jumlah hasil praktikum tersimpan, termasuk percobaan yang sedang berjalan.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[480px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th scope="col" class="px-5 py-3">Laboratorium</th>
                                <th scope="col" class="px-5 py-3 text-right">Aktivitas</th>
                                <th scope="col" class="px-5 py-3 text-right">Selesai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($activityByLaboratory as $activity)
                                <tr>
                                    <td class="px-5 py-3">
                                        <a href="{{ route('laboratories.show', $activity->slug) }}" class="font-medium text-slate-800 hover:text-blue-700">
                                            {{ $activity->name }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-3 text-right tabular-nums text-slate-600">{{ number_format($activity->attempts) }}</td>
                                    <td class="px-5 py-3 text-right tabular-nums text-emerald-700">{{ number_format($activity->completed) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-5 py-8 text-center text-sm text-slate-500">Belum ada data laboratorium.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-4">
                    <div>
                        <h2 class="font-semibold text-slate-950">Siswa terbaru</h2>
                        <p class="mt-1 text-xs text-slate-500">Akun yang baru terdaftar.</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800">Semua pengguna →</a>
                </div>
                @forelse ($recentStudents as $student)
                    <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-3 last:border-0">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-800">{{ $student->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $student->email }}</p>
                        </div>
                        <time datetime="{{ $student->created_at->toDateString() }}" class="shrink-0 text-xs text-slate-500">{{ $student->created_at->translatedFormat('d M Y') }}</time>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-slate-500">Belum ada siswa terdaftar.</p>
                @endforelse
            </section>
        </div>

        <section>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold tracking-tight text-slate-950">Kelola konten pembelajaran</h2>
                    <p class="mt-1 text-sm text-slate-600">Kelola materi dan eksperimen yang ditampilkan kepada siswa.</p>
                </div>
            </div>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <a href="{{ route('admin.materials.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 transition hover:border-blue-300 hover:shadow-lg">
                    <p class="text-sm font-semibold text-blue-700">Materi pembelajaran</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-950">{{ number_format($statistics['materials']) }}</p>
                    <span class="mt-3 inline-flex text-sm font-semibold text-slate-600 group-hover:text-blue-700">Buka pengelolaan materi →</span>
                </a>
                <a href="{{ route('admin.experiments.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 transition hover:border-blue-300 hover:shadow-lg">
                    <p class="text-sm font-semibold text-blue-700">Panduan eksperimen</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-950">{{ number_format($statistics['experiments']) }}</p>
                    <span class="mt-3 inline-flex text-sm font-semibold text-slate-600 group-hover:text-blue-700">Buka pengelolaan eksperimen →</span>
                </a>
            </div>
        </section>
    </section>
@endsection
