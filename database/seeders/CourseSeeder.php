<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::truncate();
        Course::factory()->php()->create();
        Course::factory()->vuejs()->create();
        Course::factory()->livewire()->create();
        Course::factory()->alpinejs()->create();
        Course::factory()->laravel()->create();
    }
}
