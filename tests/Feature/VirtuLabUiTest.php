<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VirtuLabUiTest extends TestCase
{
    use RefreshDatabase;

    public function test_virtulab_dashboard_is_accessible(): void
    {
        $response = $this->get(route('virtulab.index'));

        $response->assertOk();
        $response->assertSee('Gerak Parabola');
        $response->assertSee('Reaksi Asam–Basa');
        $response->assertSee('Rangkaian Listrik');
        $response->assertSee('data-jakarta-clock', false);
    }

    public function test_virtulab_lab_pages_render_for_valid_slugs_and_404_for_invalid_slug(): void
    {
        foreach (['physics', 'chemistry', 'electrical'] as $slug) {
            $this->get(route('virtulab.lab', $slug))
                ->assertOk()
                ->assertSee('vlSceneViewport');
        }

        $this->get(route('virtulab.lab', 'unknown-lab'))
            ->assertNotFound();
    }
}
