<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Users\Models\User;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition()
    {
        return [
            'title' => str(fake()->words(mt_rand(3, 10), asText: true))->title(),
            'category' => fake()->randomElement(['Crew', 'Story', 'Fleet']),
            'content' => fake()->paragraphs(mt_rand(1, 10), asText: true),
            'user_id' => fn () => User::inRandomOrder()->first(),
            'published' => false,
            'published_at' => null,
        ];
    }

    public function published()
    {
        return $this->state([
            'published' => true,
            'published_at' => now(),
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Announcement $announcement) {
            $users = User::active()->get();

            $users->each(fn (User $user) => AnnouncementNotification::create([
                'announcement_id' => $announcement->id,
                'user_id' => $user->id,
                'is_seen' => $announcement->user_id === $user->id ? true : fake()->boolean(),
            ]));
        });
    }
}
