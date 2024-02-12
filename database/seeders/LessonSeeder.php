<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lesson::truncate();

        Course::query()->select('id', 'title')->get()->map(function ($course) {
            Lesson::factory()->comment($course)->create();
            Lesson::factory()->variables($course)->create();
            Lesson::factory()->print($course)->create();
            Lesson::factory()->dataTypes($course)->create();
        });
    }
}
