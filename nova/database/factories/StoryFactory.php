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
    protected $model = Story::class;

    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->words($this->faker->numberBetween(1, 5), asText: true)),
            'status' => $this->faker->randomElement([Upcoming::$name, Current::$name, Completed::$name]),
            'description' => $this->faker->sentences($this->faker->numberBetween(1, 5), asText: true),
        ];
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
            'started_at' => $this->faker->date(),
        ]);
    }

    public function withEndDate()
    {
        return $this->state([
            'ended_at' => $this->faker->date(),
        ]);
    }

    public function withParent(?Story $parent = null)
    {
        return $this->state([
            'parent_id' => $parent?->id ?? Story::factory(),
        ]);
    }
}
