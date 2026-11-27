<?php

namespace Tests\Feature;

use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/admin-only-test-route', fn (): string => 'Allowed')
            ->middleware(['auth', 'role:admin']);
    }

    public function test_administrator_can_access_a_role_protected_route(): void
    {
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);

        $response = $this->actingAs($administrator)->get('/admin-only-test-route');

        $response->assertOk();
        $response->assertSeeText('Allowed');
    }

    public function test_student_is_forbidden_from_an_administrator_route(): void
    {
        $student = User::factory()->create([
            'role' => UserRole::Student,
        ]);

        $response = $this->actingAs($student)->get('/admin-only-test-route');

        $response->assertForbidden();
    }

    public function test_administrator_is_forbidden_from_a_student_route(): void
    {
        Route::get('/student-only-test-route', fn (): string => 'Student area')
            ->middleware(['auth', 'role:student']);

        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);

        $response = $this->actingAs($administrator)->get('/student-only-test-route');

        $response->assertForbidden();
    }
}
