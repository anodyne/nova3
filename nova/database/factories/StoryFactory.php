<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanAddMedia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Stories\Models\States\StoryStatus\Completed;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\States\StoryStatus\Ongoing;
use Nova\Stories\Models\States\StoryStatus\Upcoming;
use Nova\Stories\Models\Story;

/** @extends Factory<Story> */
class StoryFactory extends Factory
{
    use CanAddMedia;

    protected $model = Story::class;

    public function completed(): static
    {
        return $this->state([
            'status' => Completed::$name,
            'started_at' => now()->subMonths(mt_rand(1, 6)),
            'ended_at' => now(),
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Story $story): void {
            $this->addRandomMedia(
                model: $story,
                source: 'media/samples/stories',
                destination: 'media/samples',
                mediaCollection: 'story-image'
            );
        });
    }

    public function current(): static
    {
        return $this->state([
            'status' => Current::$name,
            'started_at' => now()->subMonths(mt_rand(1, 6)),
        ]);
    }

    public function definition(): array
    {
        return [
            'title' => ucfirst(rtrim(fake()->sentence(mt_rand(1, 8), variableNbWords: false), '.')),

            'description' => fake()->sentences(mt_rand(1, 5), asText: true),

            'status' => fake()->randomElement([Upcoming::$name, Current::$name, Completed::$name]),
        ];
    }

    public function ongoing(): static
    {
        return $this->state([
            'status' => Ongoing::$name,
            'started_at' => now()->subMonths(mt_rand(1, 6)),
        ]);
    }

    public function upcoming(): static
    {
        return $this->state([
            'status' => Upcoming::$name,
        ]);
    }

    public function withEndDate(): static
    {
        return $this->state([
            'ended_at' => fake()->date(),
        ]);
    }

    public function withParent(?Story $parent = null): static
    {
        return $this->state([
            'parent_id' => $parent->id ?? Story::factory(),
        ]);
    }

    public function withStartDate(): static
    {
        return $this->state([
            'started_at' => fake()->date(),
        ]);
    }
}
