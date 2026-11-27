<?php

namespace App\Console\Commands;

use App\Models\User;
use App\UserRole;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('users:assign-role {email} {role : admin or student}')]
#[Description('Assign an administrator or student role to an existing user')]
class AssignUserRole extends Command
{
    public function handle(): int
    {
        $role = UserRole::tryFrom((string) $this->argument('role'));

        if ($role === null) {
            $this->error('Role harus bernilai admin atau student.');

            return self::FAILURE;
        }

        $email = (string) $this->argument('email');
        $updated = DB::transaction(function () use ($email, $role): ?bool {
            $administrators = User::query()
                ->where('role', UserRole::Administrator->value)
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            $user = User::query()
                ->where('email', $email)
                ->lockForUpdate()
                ->first();

            if ($user === null) {
                return null;
            }

            if (
                $user->role === UserRole::Administrator
                && $role === UserRole::Student
                && $administrators->count() <= 1
            ) {
                return false;
            }

            $user->role = $role;
            $user->save();

            return true;
        });

        if ($updated === null) {
            $this->error('Pengguna dengan email tersebut tidak ditemukan.');

            return self::FAILURE;
        }

        if (! $updated) {
            $this->error('Administrator terakhir tidak dapat diturunkan rolenya.');

            return self::FAILURE;
        }

        $this->info("Role pengguna {$email} berhasil diubah menjadi {$role->value}.");

        return self::SUCCESS;
    }
}
