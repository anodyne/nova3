<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Stories\Models\States\StoryStatus\Completed;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\States\StoryStatus\Ongoing;
use Nova\Stories\Models\States\StoryStatus\Upcoming;
use Nova\Stories\Models\Story;

class StoryFactory extends Factory
{
    use Concerns\CanAddMedia;

    protected $model = Story::class;

    public function definition()
    {
        return [
            'title' => ucfirst(fake()->words(mt_rand(1, 8), asText: true)),

            'description' => fake()->sentences(mt_rand(1, 5), asText: true),

            'status' => fake()->randomElement([Upcoming::$name, Current::$name, Completed::$name]),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Story $story) {
            $this->addRandomMedia(
                model: $story,
                source: 'media/samples/stories',
                destination: 'media/samples',
                mediaCollection: 'story-image'
            );
        });
    }

    public function upcoming()
    {
        return $this->state([
            'status' => Upcoming::$name,
        ]);
    }

    public function current()
    {
        return $this->state([
            'status' => Current::$name,
            'started_at' => now()->subMonths(mt_rand(1, 6)),
        ]);
    }

    public function completed()
    {
        return $this->state([
            'status' => Completed::$name,
            'started_at' => now()->subMonths(mt_rand(1, 6)),
            'ended_at' => now(),
        ]);
    }

    public function ongoing()
    {
        return $this->state([
            'status' => Ongoing::$name,
            'started_at' => now()->subMonths(mt_rand(1, 6)),
        ]);
    }

    public function withStartDate()
    {
        return $this->state([
            'started_at' => fake()->date(),
        ]);
    }

    public function withEndDate()
    {
        return $this->state([
            'ended_at' => fake()->date(),
        ]);
    }

    public function withParent(?Story $parent = null)
    {
        return $this->state([
            'parent_id' => $parent?->id ?? Story::factory(),
        ]);
    }
}
