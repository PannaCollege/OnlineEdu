<?php

namespace Database\Factories;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('secret'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * create admin
     */
    public function admin(array $admin): static
    {
        return $this->state(function (array $attributes) use ($admin) {
            return [
                'name' => $admin['name'],
                'email' => $admin['email'],
                'username' => trim(str_replace(' ', '', Str::lower($admin['name']))),
                'type' => UserType::ADMIN(),
            ];
        });
    }
}
