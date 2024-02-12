<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    /**
     * Indicate that the PHP course.
     */
    public function php(): Factory
    {
        return $this->state(function () {
            return [
                'title' => 'PHP',
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'instructor_id' => User::all()->random()->id,
            ];
        });
    }

    /**
     * Indicate that the vue.js course.
     */
    public function vuejs(): Factory
    {
        return $this->state(function () {
            return [
                'title' => 'Vue.js',
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'instructor_id' => User::all()->random()->id,
            ];
        });
    }

    /**
     * Indicate that the Livewire course.
     */
    public function livewire(): Factory
    {
        return $this->state(function () {
            return [
                'title' => 'Livewire',
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'instructor_id' => User::all()->random()->id,
            ];
        });
    }

    /**
     * Indicate that the Alpine.js course.
     */
    public function alpinejs(): Factory
    {
        return $this->state(function () {
            return [
                'title' => 'Alpine.js',
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'instructor_id' => User::all()->random()->id,
            ];
        });
    }

    /**
     * Indicate that the Laravel course.
     */
    public function laravel(): Factory
    {
        return $this->state(function () {
            return [
                'title' => 'Laravel',
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'instructor_id' => User::all()->random()->id,
            ];
        });
    }
}
