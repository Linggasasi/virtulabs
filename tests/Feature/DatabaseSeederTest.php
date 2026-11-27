<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_adds_only_the_required_laboratory_catalog(): void
    {
        $this->seed();
        $this->seed();

        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('laboratories', 3);
        $this->assertDatabaseHas('laboratories', ['slug' => 'fisika']);
        $this->assertDatabaseHas('laboratories', ['slug' => 'kimia']);
        $this->assertDatabaseHas('laboratories', ['slug' => 'biologi']);
    }
}
