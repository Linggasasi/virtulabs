<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_a_student_with_a_hashed_password(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Siswa Uji',
            'email' => 'student@example.test',
            'password' => 'safe-password-123',
            'password_confirmation' => 'safe-password-123',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('dashboard'));

        $user = User::where('email', 'student@example.test')->sole();

        $this->assertAuthenticatedAs($user);
        $this->assertSame('student', $user->role->value);
        $this->assertTrue(Hash::check('safe-password-123', $user->password));

        $this->get(route('dashboard'))->assertRedirect(route('student.dashboard'));
    }

    public function test_registration_rejects_missing_required_fields(): void
    {
        $response = $this->from(route('register'))
            ->post(route('register.store'), []);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_login_authenticates_a_valid_user(): void
    {
        $user = User::factory()->create([
            'email' => 'student@example.test',
            'password' => 'safe-password-123',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'student@example.test',
            'password' => 'safe-password-123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'student@example.test',
            'password' => 'safe-password-123',
        ]);

        $response = $this->from(route('login'))->post(route('login.store'), [
            'email' => 'student@example.test',
            'password' => 'incorrect-password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_attempts_are_rate_limited_per_email_and_ip(): void
    {
        foreach (range(1, 5) as $attempt) {
            $this->post(route('login.store'), [
                'email' => 'unknown@example.test',
                'password' => 'incorrect-password',
            ])->assertRedirect();
        }

        $response = $this->post(route('login.store'), [
            'email' => 'unknown@example.test',
            'password' => 'incorrect-password',
        ]);

        $response->assertStatus(429);
        $this->assertGuest();
    }

    public function test_logout_invalidates_the_authenticated_session(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
