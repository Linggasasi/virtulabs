@extends('layouts.admin')

@section('title', $experiment ? 'Ubah eksperimen' : 'Tambah eksperimen')

@section('admin-content')
    <section class="mx-auto max-w-3xl">
        <a href="{{ route('admin.experiments.index') }}" class="text-sm font-semibold text-slate-500 hover:text-blue-700">← Kembali ke eksperimen</a>
        <div class="mt-5">
            <p class="text-sm font-semibold text-blue-700">Konten pembelajaran</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">{{ $experiment ? 'Ubah eksperimen' : 'Tambah eksperimen' }}</h1>
            <p class="mt-2 text-sm text-slate-600">Isi tujuan dan panduan yang akan digunakan siswa.</p>
        </div>

        @if ($errors->any())
            <div class="mt-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800" role="alert">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $experiment ? route('admin.experiments.update', $experiment) : route('admin.experiments.store') }}" class="mt-6 space-y-5 rounded-2xl border border-slate-200 bg-white p-5 sm:p-7">
            @csrf
            @if ($experiment)
                @method('PUT')
            @endif
            <div>
                <label for="laboratory_id" class="mb-2 block text-sm font-semibold text-slate-700">Laboratorium</label>
                <select id="laboratory_id" name="laboratory_id" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                    <option value="">Pilih laboratorium</option>
                    @foreach ($laboratories as $laboratory)
                        <option value="{{ $laboratory->id }}" @selected(old('laboratory_id', $experiment?->laboratory_id) == $laboratory->id)>{{ $laboratory->name }}</option>
                    @endforeach
                </select>
                @error('laboratory_id')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="material_id" class="mb-2 block text-sm font-semibold text-slate-700">Materi terkait <span class="font-normal text-slate-500">(opsional)</span></label>
                <select id="material_id" name="material_id" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                    <option value="">Tidak terkait materi tertentu</option>
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}" @selected(old('material_id', $experiment?->material_id) == $material->id)>{{ $material->laboratory->name }} — {{ $material->title }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-slate-500">Materi yang dipilih harus berasal dari laboratorium yang sama.</p>
                @error('material_id')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Judul eksperimen</label>
                <input id="title" name="title" value="{{ old('title', $experiment?->title) }}" required maxlength="255" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                @error('title')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi</label>
                <textarea id="description" name="description" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">{{ old('description', $experiment?->description) }}</textarea>
                @error('description')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="objectives" class="mb-2 block text-sm font-semibold text-slate-700">Tujuan eksperimen</label>
                <textarea id="objectives" name="objectives" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">{{ old('objectives', $experiment?->objectives) }}</textarea>
                @error('objectives')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="instructions" class="mb-2 block text-sm font-semibold text-slate-700">Panduan / instruksi</label>
                <textarea id="instructions" name="instructions" rows="8" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">{{ old('instructions', $experiment?->instructions) }}</textarea>
                @error('instructions')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="simulation_type" class="mb-2 block text-sm font-semibold text-slate-700">Jenis simulasi <span class="font-normal text-slate-500">(opsional)</span></label>
                <input id="simulation_type" name="simulation_type" value="{{ old('simulation_type', $experiment?->simulation_type) }}" maxlength="255" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                @error('simulation_type')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.experiments.index') }}" class="rounded-xl border border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">Batal</a>
                <button type="submit" class="rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">{{ $experiment ? 'Simpan perubahan' : 'Simpan eksperimen' }}</button>
            </div>
        </form>
    </section>
@endsection
