@extends('layouts.admin')

@section('title', 'Kelola pengguna')

@section('admin-content')
    <section>
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-emerald-700">Administrator</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Kelola pengguna</h1>
                <p class="mt-2 text-sm text-slate-600">Periksa akun terdaftar dan atur role sesuai tanggung jawabnya.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-emerald-700"><span aria-hidden="true">←</span> Kembali ke ringkasan</a>
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

        <div class="mt-7 overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="font-semibold text-slate-950">Akun pengguna</h2>
                    <p class="mt-1 text-xs text-slate-500">Data pengguna aktual · {{ $users->total() }} akun</p>
                </div>
            </div>

            @if ($users->isEmpty())
                <div class="px-6 py-12 text-center">
                    <p class="text-sm font-semibold text-slate-800">Belum ada akun terdaftar</p>
                    <p class="mt-1 text-sm text-slate-500">Akun siswa akan muncul di sini setelah mereka mendaftar.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[720px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th scope="col" class="px-6 py-3">Pengguna</th>
                                <th scope="col" class="px-6 py-3">Terdaftar</th>
                                <th scope="col" class="px-6 py-3">Role</th>
                                <th scope="col" class="px-6 py-3 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ $user->email }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $user->role === \App\UserRole::Administrator ? 'bg-violet-50 text-violet-700' : 'bg-emerald-50 text-emerald-700' }}">
                                            {{ $user->role === \App\UserRole::Administrator ? 'Administrator' : 'Siswa' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($user->is(auth()->user()))
                                            <span class="block text-right text-xs font-medium text-slate-400">Akun aktif</span>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="flex justify-end gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <label for="role-{{ $user->id }}" class="sr-only">Role {{ $user->name }}</label>
                                                <select id="role-{{ $user->id }}" name="role" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                                                    <option value="student" @selected($user->role === \App\UserRole::Student)>Siswa</option>
                                                    <option value="admin" @selected($user->role === \App\UserRole::Administrator)>Administrator</option>
                                                </select>
                                                <button type="submit" class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">Simpan</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($users->hasPages())
                    <div class="border-t border-slate-100 px-5 py-4 sm:px-6">{{ $users->links() }}</div>
                @endif
            @endif
        </div>
        <p class="mt-4 text-xs leading-5 text-slate-500">Akun yang sedang digunakan tidak dapat mengubah rolenya sendiri, dan administrator terakhir tidak dapat diturunkan rolenya.</p>
    </section>
@endsection
