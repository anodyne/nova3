<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Foundation\Enums\PublishStatus;
use Nova\Users\Models\User;

/** @extends Factory<Announcement> */
class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function configure(): static
    {
        return $this->afterCreating(function (Announcement $announcement): void {
            $users = User::active()->get();

            $users->each(fn (User $user) => AnnouncementNotification::create([
                'announcement_id' => $announcement->id,
                'user_id' => $user->id,
                'is_seen' => $announcement->user_id === $user->id ? true : fake()->boolean(),
            ]));
        });
    }

    public function definition(): array
    {
        return [
            'title' => str(fake()->words(mt_rand(3, 10), asText: true))->title()->toString(),
            'category' => fake()->randomElement(['Crew', 'Story', 'Fleet']),
            'content' => fake()->paragraphs(mt_rand(1, 10), asText: true),
            'user_id' => fn () => User::inRandomOrder()->first(),
            'status' => fn () => Arr::randomWeightedElement([
                PublishStatus::Draft->value => 25,
                PublishStatus::Published->value => 75,
            ]),
            'published_at' => fn (array $attributes): ?CarbonInterface => $attributes['status'] === PublishStatus::Published->value ? now() : null,
        ];
    }

    public function draft(): static
    {
        return $this->state([
            'status' => PublishStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function pending(): static
    {
        return $this->state([
            'status' => PublishStatus::Pending,
            'published_at' => null,
        ]);
    }

    public function published(): static
    {
        return $this->state([
            'status' => PublishStatus::Published,
            'published_at' => now(),
        ]);
    }
}
