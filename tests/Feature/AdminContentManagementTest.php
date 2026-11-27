<?php

namespace Tests\Feature;

use App\Models\Experiment;
use App\Models\Laboratory;
use App\Models\Material;
use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_create_and_update_a_material(): void
    {
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);
        $laboratory = Laboratory::factory()->create();

        $this->actingAs($administrator)
            ->post(route('admin.materials.store'), [
                'laboratory_id' => $laboratory->id,
                'title' => 'Dasar optik',
                'description' => 'Pengenalan cahaya.',
                'content' => 'Cahaya merambat lurus.',
            ])
            ->assertRedirect(route('admin.materials.index'));

        $material = Material::query()->sole();
        $this->assertSame('Dasar optik', $material->title);

        $this->actingAs($administrator)
            ->put(route('admin.materials.update', $material), [
                'laboratory_id' => $laboratory->id,
                'title' => 'Dasar optik geometris',
                'description' => 'Pengenalan sifat cahaya.',
                'content' => 'Cahaya dapat dipantulkan dan dibiaskan.',
            ])
            ->assertRedirect(route('admin.materials.index'));

        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'title' => 'Dasar optik geometris',
            'content' => 'Cahaya dapat dipantulkan dan dibiaskan.',
        ]);
    }

    public function test_administrator_can_create_and_update_an_experiment_for_a_related_material(): void
    {
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);
        $laboratory = Laboratory::factory()->create();
        $material = Material::factory()->for($laboratory)->create();

        $this->actingAs($administrator)
            ->post(route('admin.experiments.store'), [
                'laboratory_id' => $laboratory->id,
                'material_id' => $material->id,
                'title' => 'Pengamatan pembiasan',
                'description' => 'Mengamati pembiasan cahaya.',
                'objectives' => 'Mengenali perubahan arah cahaya.',
                'instructions' => 'Amati jalur cahaya dan catat hasilnya.',
                'simulation_type' => 'optics',
            ])
            ->assertRedirect(route('admin.experiments.index'));

        $experiment = Experiment::query()->sole();

        $this->assertDatabaseHas('experiments', [
            'id' => $experiment->id,
            'laboratory_id' => $laboratory->id,
            'material_id' => $material->id,
            'title' => 'Pengamatan pembiasan',
        ]);

        $this->actingAs($administrator)
            ->put(route('admin.experiments.update', $experiment), [
                'laboratory_id' => $laboratory->id,
                'material_id' => $material->id,
                'title' => 'Mengamati pembiasan cahaya',
                'description' => 'Perbarui panduan.',
                'objectives' => 'Mengamati arah cahaya.',
                'instructions' => 'Catat hasil pengamatan.',
                'simulation_type' => 'optics',
            ])
            ->assertRedirect(route('admin.experiments.index'));

        $this->assertDatabaseHas('experiments', [
            'id' => $experiment->id,
            'title' => 'Mengamati pembiasan cahaya',
        ]);
    }

    public function test_experiment_material_must_belong_to_the_selected_laboratory(): void
    {
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);
        $laboratory = Laboratory::factory()->create();
        $otherLaboratory = Laboratory::factory()->create();
        $material = Material::factory()->for($otherLaboratory)->create();

        $this->actingAs($administrator)
            ->from(route('admin.experiments.create'))
            ->post(route('admin.experiments.store'), [
                'laboratory_id' => $laboratory->id,
                'material_id' => $material->id,
                'title' => 'Eksperimen tidak valid',
            ])
            ->assertRedirect(route('admin.experiments.create'))
            ->assertSessionHasErrors('material_id');

        $this->assertDatabaseMissing('experiments', [
            'title' => 'Eksperimen tidak valid',
        ]);
    }

    public function test_student_cannot_access_or_create_administrator_content(): void
    {
        $student = User::factory()->create([
            'role' => UserRole::Student,
        ]);
        $laboratory = Laboratory::factory()->create();

        $this->actingAs($student)
            ->get(route('admin.materials.index'))
            ->assertForbidden();

        $this->actingAs($student)
            ->get(route('admin.experiments.index'))
            ->assertForbidden();

        $this->actingAs($student)
            ->post(route('admin.materials.store'), [
                'laboratory_id' => $laboratory->id,
                'title' => 'Tidak boleh dibuat',
                'content' => 'Ditolak.',
            ])
            ->assertForbidden();

        $this->assertDatabaseCount('materials', 0);
        $this->assertDatabaseCount('experiments', 0);
    }

    public function test_guest_is_redirected_from_administrator_content_management(): void
    {
        $this->get(route('admin.materials.index'))
            ->assertRedirect(route('login'));

        $this->get(route('admin.experiments.index'))
            ->assertRedirect(route('login'));
    }

    public function test_administrator_can_open_content_management_tables(): void
    {
        $administrator = User::factory()->create([
            'role' => UserRole::Administrator,
        ]);
        $laboratory = Laboratory::factory()->create();
        $material = Material::factory()->for($laboratory)->create();
        Experiment::factory()->for($laboratory)->for($material)->create();

        $this->actingAs($administrator)
            ->get(route('admin.materials.index'))
            ->assertOk()
            ->assertSee($material->title)
            ->assertSee(route('admin.experiments.index'));

        $this->actingAs($administrator)
            ->get(route('admin.materials.create'))
            ->assertOk()
            ->assertSee('Isi materi');

        $this->actingAs($administrator)
            ->get(route('admin.experiments.index'))
            ->assertOk()
            ->assertSee('Daftar eksperimen')
            ->assertSee($material->title);

        $experiment = Experiment::query()->sole();

        $this->actingAs($administrator)
            ->get(route('admin.experiments.create'))
            ->assertOk()
            ->assertSee('Panduan / instruksi');

        $this->actingAs($administrator)
            ->get(route('admin.experiments.edit', $experiment))
            ->assertOk()
            ->assertSee($experiment->title);
    }
}
