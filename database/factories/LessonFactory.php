<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    /**
     * Indicate that the comment lesson.
     */
    public function comment($course): Factory
    {
        return $this->state(function () use ($course) {
            return [
                'title' => $course->title . ' Comments',
                'content' => $this->faker->text(),
                'order' => 1,
                'course_id' => $course->id,
            ];
        });
    }

    /**
     * Indicate that the variables lesson.
     */
    public function variables($course): Factory
    {
        return $this->state(function () use ($course) {
            return [
                'title' => $course->title . ' Variables',
                'content' => $this->faker->text(),
                'order' => 2,
                'course_id' => $course->id,
            ];
        });
    }

    /**
     * Indicate that the print lesson.
     */
    public function print($course): Factory
    {
        return $this->state(function () use ($course) {
            return [
                'title' => $course->title . ' Print',
                'content' => $this->faker->text(),
                'order' => 3,
                'course_id' => $course->id,
            ];
        });
    }

    /**
     * Indicate that the data type lesson.
     */
    public function dataTypes($course): Factory
    {
        return $this->state(function () use ($course) {
            return [
                'title' => $course->title . ' Data Types',
                'content' => $this->faker->text(),
                'order' => 4,
                'course_id' => $course->id,
            ];
        });
    }
}
