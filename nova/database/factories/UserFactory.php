<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Actions\TrackStatusUpdate;
use Nova\Users\Actions\PopulateAccountPreferences;
use Nova\Users\Actions\PopulateNotificationPreferences;
use Nova\Users\Data\PronounsData;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\User;

class UserFactory extends Factory
{
    use Concerns\CanAddMedia;

    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => fn (array $attributes) => sprintf(
                '%s %s',
                fake()->firstName($attributes['pronouns']->value),
                fake()->lastName($attributes['pronouns']->value)
            ),
            'email' => fake()->unique()->safeEmail,
            'password' => 'secret',
            'pronouns' => PronounsData::from(['value' => fake()->randomElement(['male', 'female'])]),
            'force_password_reset' => false,
        ];
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

            TrackStatusUpdate::run($user);
        });
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
