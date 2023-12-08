<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Nova\Users\Data\PronounsData;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('secret'),
            'pronouns' => PronounsData::from(['value' => 'none']),
            'appearance' => 'light',
        ];
    }

    public function verifiedEmail()
    {
        return $this->state([
            'email_verified_at' => now(),
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

    public function pending()
    {
        return $this->state([
            'status' => Pending::class,
        ]);
    }
}
