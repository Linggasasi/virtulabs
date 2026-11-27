@extends('layouts.admin')

@section('title', 'Kelola materi')

@section('admin-content')
    <section>
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-blue-700">Konten pembelajaran</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Materi</h1>
                <p class="mt-2 text-sm text-slate-600">Buat dan perbarui materi untuk tiap laboratorium.</p>
            </div>
            <a href="{{ route('admin.materials.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
                Tambah materi <span aria-hidden="true">+</span>
            </a>
        </div>

        <div class="mt-7 overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <div>
                    <h2 class="font-semibold text-slate-950">Daftar materi</h2>
                    <p class="mt-1 text-xs text-slate-500">{{ number_format($materials->total()) }} materi tersimpan</p>
                </div>
                <a href="{{ route('admin.experiments.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Lihat eksperimen →</a>
            </div>

            @if ($materials->isEmpty())
                <div class="px-6 py-12 text-center">
                    <p class="text-sm font-semibold text-slate-800">Belum ada materi</p>
                    <p class="mt-1 text-sm text-slate-500">Tambahkan materi untuk mulai melengkapi laboratorium.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th scope="col" class="px-5 py-3">Judul materi</th>
                                <th scope="col" class="px-5 py-3">Laboratorium</th>
                                <th scope="col" class="px-5 py-3 text-right">Eksperimen</th>
                                <th scope="col" class="px-5 py-3">Diperbarui</th>
                                <th scope="col" class="px-5 py-3 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($materials as $material)
                                <tr>
                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-slate-900">{{ $material->title }}</p>
                                        <p class="mt-1 max-w-md truncate text-xs text-slate-500">{{ $material->description }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-slate-600">{{ $material->laboratory->name }}</td>
                                    <td class="px-5 py-4 text-right tabular-nums text-slate-600">{{ $material->experiments_count }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $material->updated_at->translatedFormat('d M Y') }}</td>
                                    <td class="px-5 py-4 text-right">
                                        <a href="{{ route('admin.materials.edit', $material) }}" class="font-semibold text-blue-700 hover:text-blue-800">Ubah</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($materials->hasPages())
                    <div class="border-t border-slate-100 px-5 py-4">{{ $materials->links() }}</div>
                @endif
            @endif
        </div>
    </section>
@endsection
