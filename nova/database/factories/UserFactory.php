<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Nova\Users\Models\User;
use Illuminate\Support\Facades\Hash;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Inactive;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'pronouns' => $this->faker->randomElement(['male', 'female', 'neutral']),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverifiedEmail()
    {
        return $this->state([
            'email_verified_at' => null,
        ]);
    }

    public function forcePasswordReset()
    {
        return $this->state([
            'force_password_reset' => true,
        ]);
    }

    public function active()
    {
        return $this->state([
            'status' => Active::class,
        ]);
    }

    public function inactive()
    {
        return $this->state([
            'status' => Inactive::class,
        ]);
    }
}
