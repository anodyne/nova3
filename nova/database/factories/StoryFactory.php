<?php

namespace Database\Factories;

use Nova\Stories\Models\Story;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Upcoming;
use Nova\Stories\Models\States\Completed;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'allow_posting' => true,
        ];
    }

    public function withoutPosting()
    {
        return $this->state([
            'allow_posting' => false,
        ]);
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
