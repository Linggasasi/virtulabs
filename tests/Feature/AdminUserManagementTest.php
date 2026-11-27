<?php

namespace Tests\Feature;

use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_promote_a_student(): void
    {
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);
        $student = User::factory()->create([
            'role' => UserRole::Student,
        ]);

        $response = $this->actingAs($administrator)
            ->from(route('admin.users.index'))
            ->patch(route('admin.users.update-role', $student), [
                'role' => UserRole::Administrator->value,
            ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'role' => UserRole::Administrator->value,
        ]);
    }

    public function test_administrator_cannot_demote_themselves(): void
    {
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);

        $response = $this->actingAs($administrator)
            ->from(route('admin.users.index'))
            ->patch(route('admin.users.update-role', $administrator), [
                'role' => UserRole::Student->value,
            ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHasErrors('role');
        $this->assertDatabaseHas('users', [
            'id' => $administrator->id,
            'role' => UserRole::Administrator->value,
        ]);
    }

    public function test_administrator_cannot_demote_the_last_administrator(): void
    {
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);
        $student = User::factory()->create([
            'role' => UserRole::Student,
        ]);

        $response = $this->actingAs($administrator)
            ->from(route('admin.users.index'))
            ->patch(route('admin.users.update-role', $administrator), [
                'role' => UserRole::Student->value,
            ]);

        $response->assertSessionHasErrors('role');
        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'role' => UserRole::Student->value,
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $administrator->id,
            'role' => UserRole::Administrator->value,
        ]);
    }

    public function test_student_cannot_open_or_update_administrator_user_management(): void
    {
        $student = User::factory()->create([
            'role' => UserRole::Student,
        ]);
        $target = User::factory()->create([
            'role' => UserRole::Student,
        ]);

        $this->actingAs($student)
            ->get(route('admin.users.index'))
            ->assertForbidden();

        $this->actingAs($student)
            ->patch(route('admin.users.update-role', $target), [
                'role' => UserRole::Administrator->value,
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'role' => UserRole::Student->value,
        ]);
    }
}
