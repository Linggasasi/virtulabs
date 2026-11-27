<?php

namespace Database\Seeders;

use App\Models\Laboratory;
use Illuminate\Database\Seeder;

class LaboratorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laboratories = [
            [
                'name' => 'Laboratorium Fisika',
                'slug' => 'fisika',
                'description' => 'Jelajahi gerak, gaya, energi, listrik, gelombang, dan optik melalui pembelajaran berbasis eksperimen.',
            ],
            [
                'name' => 'Laboratorium Kimia',
                'slug' => 'kimia',
                'description' => 'Pelajari atom, ikatan, larutan, asam-basa, dan reaksi melalui kegiatan virtual yang aman.',
            ],
            [
                'name' => 'Laboratorium Biologi',
                'slug' => 'biologi',
                'description' => 'Amati sel, jaringan, sistem organ, mikroorganisme, ekosistem, dan genetika.',
            ],
        ];

        foreach ($laboratories as $laboratory) {
            Laboratory::query()->firstOrCreate(
                ['slug' => $laboratory['slug']],
                $laboratory,
            );
        }
    }
}
