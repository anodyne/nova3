<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Ongoing;
use Nova\Stories\Models\States\Upcoming;
use Nova\Stories\Models\Story;

class StoryFactory extends Factory
{
    protected $model = Story::class;

    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->words($this->faker->numberBetween(1, 5), true)),
            'status' => $this->faker->randomElement([Upcoming::class, Current::class, Completed::class]),
            'description' => $this->faker->sentences($this->faker->numberBetween(1, 5), true),
            'parent_id' => 1,
        ];
    }

    public function upcoming()
    {
        return $this->state([
            'status' => Upcoming::class,
        ]);
    }

    public function current()
    {
        return $this->state([
            'status' => Current::class,
        ]);
    }

    public function completed()
    {
        return $this->state([
            'status' => Completed::class,
        ]);
    }

    public function ongoing()
    {
        return $this->state([
            'status' => Ongoing::class,
        ]);
    }

    public function withStartDate()
    {
        return $this->state([
            'start_date' => $this->faker->date(),
        ]);
    }

    public function withEndDate()
    {
        return $this->state([
            'end_date' => $this->faker->date(),
        ]);
    }
}
