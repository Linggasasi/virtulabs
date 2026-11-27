<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRoleRequest;
use App\Models\User;
use App\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()
                ->select(['id', 'name', 'email', 'role', 'created_at'])
                ->orderBy('name')
                ->paginate(15),
        ]);
    }

    public function updateRole(UpdateUserRoleRequest $request, User $user): RedirectResponse
    {
        $newRole = UserRole::from($request->validated('role'));

        DB::transaction(function () use ($request, $user, $newRole): void {
            $administrators = User::query()
                ->where('role', UserRole::Administrator->value)
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            $target = User::query()
                ->lockForUpdate()
                ->findOrFail($user->getKey());

            if ($target->is($request->user()) && $target->role !== $newRole) {
                throw ValidationException::withMessages([
                    'role' => 'Anda tidak dapat mengubah role akun sendiri.',
                ]);
            }

            if (
                $target->role === UserRole::Administrator
                && $newRole === UserRole::Student
                && $administrators->count() <= 1
            ) {
                throw ValidationException::withMessages([
                    'role' => 'Administrator terakhir tidak dapat diturunkan rolenya.',
                ]);
            }

            $target->role = $newRole;
            $target->save();
        });

        return back()->with('status', 'Role pengguna berhasil diperbarui.');
    }
}
