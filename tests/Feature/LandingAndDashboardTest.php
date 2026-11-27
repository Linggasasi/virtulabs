<?php

namespace Tests\Feature;

use App\Models\Experiment;
use App\Models\ExperimentResult;
use App\Models\Laboratory;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingAndDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_displays_laboratories_from_the_database(): void
    {
        Laboratory::factory()->create([
            'name' => 'Laboratorium Fisika',
            'slug' => 'fisika',
        ]);
        Laboratory::factory()->create([
            'name' => 'Laboratorium Kimia',
            'slug' => 'kimia',
        ]);
        Laboratory::factory()->create([
            'name' => 'Laboratorium Biologi',
            'slug' => 'biologi',
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Laboratorium Fisika');
        $response->assertSee('Laboratorium Kimia');
        $response->assertSee('Laboratorium Biologi');
        $response->assertSee(route('register'));
        $response->assertSee('data-jakarta-clock', false);
    }

    public function test_dashboard_redirects_students_and_administrators_to_their_own_area(): void
    {
        $student = User::factory()->create([
            'role' => UserRole::Student,
        ]);
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);

        $this->actingAs($student)
            ->get(route('dashboard'))
            ->assertRedirect(route('student.dashboard'));

        $this->actingAs($administrator)
            ->get(route('dashboard'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_dashboard_routes_forbid_the_opposite_role_and_redirect_guests(): void
    {
        $student = User::factory()->create([
            'role' => UserRole::Student,
        ]);
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);

        $this->get(route('dashboard'))->assertRedirect(route('login'));

        $this->actingAs($student)
            ->get(route('admin.dashboard'))
            ->assertForbidden();

        $this->actingAs($administrator)
            ->get(route('student.dashboard'))
            ->assertForbidden();
    }

    public function test_student_dashboard_uses_only_the_students_saved_progress(): void
    {
        $student = User::factory()->create([
            'role' => UserRole::Student,
        ]);
        $otherStudent = User::factory()->create([
            'role' => UserRole::Student,
        ]);
        $laboratory = Laboratory::factory()->create();
        $material = Material::factory()->for($laboratory)->create();
        $experiment = Experiment::factory()
            ->for($laboratory)
            ->for($material)
            ->create();
        ExperimentResult::factory()->for($student)->for($experiment)->create([
            'status' => 'completed',
        ]);
        ExperimentResult::factory()->for($otherStudent)->for($experiment)->create([
            'status' => 'completed',
        ]);
        $quiz = Quiz::factory()->for($laboratory)->create();
        QuizResult::factory()->for($student)->for($quiz)->create();

        $response = $this->actingAs($student)->get(route('student.dashboard'));

        $response->assertOk();
        $response->assertSee('Progres pembelajaran');
        $response->assertSee('Riwayat evaluasi');
        $response->assertSee('data-jakarta-clock', false);
        $response->assertViewHas('statistics', function (array $statistics): bool {
            return $statistics['experimentsCompleted'] === 1
                && $statistics['quizzesTaken'] === 1;
        });
        $response->assertViewHas('progressPercentage', 100);
    }

    public function test_administrator_dashboard_shows_database_statistics_and_navigation(): void
    {
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);
        $student = User::factory()->create([
            'role' => UserRole::Student,
        ]);
        $laboratory = Laboratory::factory()->create([
            'name' => 'Laboratorium Kimia',
            'slug' => 'kimia',
        ]);
        $material = Material::factory()->for($laboratory)->create();
        $experiment = Experiment::factory()->for($laboratory)->for($material)->create();
        ExperimentResult::factory()->for($student)->for($experiment)->create([
            'status' => 'completed',
        ]);

        $response = $this->actingAs($administrator)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Laboratorium Kimia');
        $response->assertSee(route('admin.users.index'));
        $response->assertSee(route('admin.materials.index'));
        $response->assertSee(route('admin.experiments.index'));
        $response->assertSee('data-jakarta-clock', false);
        $response->assertViewHas('statistics', function (array $statistics): bool {
            return $statistics['students'] === 1
                && $statistics['administrators'] === 1
                && $statistics['laboratories'] === 1
                && $statistics['materials'] === 1
                && $statistics['experiments'] === 1
                && $statistics['completedExperiments'] === 1;
        });
        $response->assertViewHas('activityByLaboratory', function ($activity): bool {
            return $activity->sole()->attempts === 1
                && $activity->sole()->completed === 1;
        });
    }

    public function test_guest_can_open_a_laboratory_overview_with_a_real_empty_state(): void
    {
        $laboratory = Laboratory::factory()->create([
            'name' => 'Laboratorium Biologi',
            'slug' => 'biologi',
        ]);

        $response = $this->get(route('laboratories.show', $laboratory->slug));

        $response->assertOk();
        $response->assertSee('Laboratorium Biologi');
        $response->assertSee('Materi belum tersedia');
        $response->assertSee('Eksperimen belum tersedia');
    }

    public function test_laboratory_pages_link_database_materials_and_experiments_to_learning_pages(): void
    {
        $laboratory = Laboratory::factory()->create([
            'name' => 'Laboratorium Fisika',
            'slug' => 'fisika',
        ]);
        $material = Material::factory()->for($laboratory)->create([
            'title' => 'Gerak lurus',
        ]);
        $experiment = Experiment::factory()->for($laboratory)->for($material)->create([
            'title' => 'Mengukur kecepatan',
        ]);

        $response = $this->get(route('laboratories.show', $laboratory->slug));

        $response->assertOk();
        $response->assertSee('Gerak lurus');
        $response->assertSee('Mengukur kecepatan');
        $response->assertSee(route('materials.show', $material));
        $response->assertSee(route('experiments.show', $experiment));
    }

    public function test_material_and_experiment_pages_display_saved_learning_content_safely(): void
    {
        $laboratory = Laboratory::factory()->create([
            'slug' => 'kimia',
            'name' => 'Laboratorium Kimia',
        ]);
        $material = Material::factory()->for($laboratory)->create([
            'content' => '<script>alert("unsafe")</script>',
        ]);
        $experiment = Experiment::factory()->for($laboratory)->for($material)->create([
            'objectives' => 'Memahami perubahan warna.',
            'instructions' => "Amati indikator.\nCatat hasilnya.",
        ]);

        $this->get(route('materials.show', $material))
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(&quot;unsafe&quot;)&lt;/script&gt;', false);

        $this->get(route('experiments.show', $experiment))
            ->assertOk()
            ->assertSee('Memahami perubahan warna.')
            ->assertSee('Amati indikator.')
            ->assertSee(route('materials.show', $material));
    }
}
