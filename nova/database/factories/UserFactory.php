<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanAddMedia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Actions\TrackStatusUpdate;
use Nova\Users\Actions\PopulateAccountPreferences;
use Nova\Users\Actions\PopulateNotificationPreferences;
use Nova\Users\Actions\PopulateUserModerations;
use Nova\Users\Data\PronounsData;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\User;

/** @extends Factory<User> */
class UserFactory extends Factory
{
    use CanAddMedia;

    protected $model = User::class;

    public function active(): static
    {
        return $this->state([
            'status' => Active::class,
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            $source = match ($user->pronouns->value) {
                'female' => 'media/samples/people/female',
                default => 'media/samples/people/male',
            };

            $this->addRandomMedia(
                model: $user,
                source: $source,
                destination: 'media/samples',
                mediaCollection: 'avatar'
            );

            PopulateAccountPreferences::run($user);

            PopulateNotificationPreferences::run($user);

            PopulateUserModerations::run($user);

            TrackStatusUpdate::run($user);
        });
    }

    public function definition(): array
    {
        return [
            'name' => fn (array $attributes) => sprintf(
                '%s %s',
                fake()->firstName($attributes['pronouns']->value),
                fake()->lastName($attributes['pronouns']->value)
            ),
            'email' => fake()->unique()->safeEmail,
            'password' => 'secret',
            'pronouns' => PronounsData::from(fake()->randomElement(['male', 'female'])),
            'force_password_reset' => false,
        ];
    }

    public function forcePasswordReset(): static
    {
        return $this->state([
            'force_password_reset' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state([
            'status' => Inactive::class,
        ]);
    }

    public function pending(): static
    {
        return $this->state([
            'status' => Pending::class,
        ]);
    }

    public function verifiedEmail(): static
    {
        return $this->state([
            'email_verified_at' => now(),
        ]);
    }
}
