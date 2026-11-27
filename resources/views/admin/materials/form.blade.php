@extends('layouts.admin')

@section('title', $material ? 'Ubah materi' : 'Tambah materi')

@section('admin-content')
    <section class="mx-auto max-w-3xl">
        <a href="{{ route('admin.materials.index') }}" class="text-sm font-semibold text-slate-500 hover:text-blue-700">← Kembali ke materi</a>
        <div class="mt-5">
            <p class="text-sm font-semibold text-blue-700">Konten pembelajaran</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">{{ $material ? 'Ubah materi' : 'Tambah materi' }}</h1>
            <p class="mt-2 text-sm text-slate-600">Materi yang disimpan akan tampil di halaman laboratorium terkait.</p>
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

        <form method="POST" action="{{ $material ? route('admin.materials.update', $material) : route('admin.materials.store') }}" class="mt-6 space-y-5 rounded-2xl border border-slate-200 bg-white p-5 sm:p-7">
            @csrf
            @if ($material)
                @method('PUT')
            @endif
            <div>
                <label for="laboratory_id" class="mb-2 block text-sm font-semibold text-slate-700">Laboratorium</label>
                <select id="laboratory_id" name="laboratory_id" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                    <option value="">Pilih laboratorium</option>
                    @foreach ($laboratories as $laboratory)
                        <option value="{{ $laboratory->id }}" @selected(old('laboratory_id', $material?->laboratory_id) == $laboratory->id)>{{ $laboratory->name }}</option>
                    @endforeach
                </select>
                @error('laboratory_id')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Judul</label>
                <input id="title" name="title" value="{{ old('title', $material?->title) }}" required maxlength="255" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                @error('title')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi singkat</label>
                <textarea id="description" name="description" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">{{ old('description', $material?->description) }}</textarea>
                @error('description')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="content" class="mb-2 block text-sm font-semibold text-slate-700">Isi materi</label>
                <textarea id="content" name="content" rows="12" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">{{ old('content', $material?->content) }}</textarea>
                @error('content')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.materials.index') }}" class="rounded-xl border border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">Batal</a>
                <button type="submit" class="rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">{{ $material ? 'Simpan perubahan' : 'Simpan materi' }}</button>
            </div>
        </form>
    </section>
@endsection
