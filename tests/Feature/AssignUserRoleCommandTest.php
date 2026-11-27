<?php

namespace Tests\Feature;

use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignUserRoleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_user_can_be_promoted_to_administrator_from_the_console(): void
    {
        $user = User::factory()->create([
            'email' => 'first-admin@example.test',
            'role' => UserRole::Student,
        ]);

        $this->artisan('users:assign-role', [
            'email' => $user->email,
            'role' => UserRole::Administrator->value,
        ])->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => UserRole::Administrator->value,
        ]);
    }

    public function test_unknown_roles_are_rejected_without_changing_user_access(): void
    {
        $user = User::factory()->create([
            'email' => 'student@example.test',
            'role' => UserRole::Student,
        ]);

        $this->artisan('users:assign-role', [
            'email' => $user->email,
            'role' => 'teacher',
        ])->assertFailed();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => UserRole::Student->value,
        ]);
    }

    public function test_command_cannot_demote_the_last_administrator(): void
    {
        $administrator = User::factory()->create([
            'email' => 'last-admin@example.test',
            'role' => UserRole::Administrator,
        ]);

        $this->artisan('users:assign-role', [
            'email' => $administrator->email,
            'role' => UserRole::Student->value,
        ])->assertFailed();

        $this->assertDatabaseHas('users', [
            'id' => $administrator->id,
            'role' => UserRole::Administrator->value,
        ]);
    }
}
