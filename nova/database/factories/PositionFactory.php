<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Enums\BasicStatus;

/** @extends Factory<Position> */
class PositionFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = Position::class;

    public function active()
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

    public function definition()
    {
        return [
            'name' => ucwords($this->faker->words($this->faker->numberBetween(1, 3), true)),
            'description' => $this->faker->sentence,
            'status' => BasicStatus::Active,
            'available' => $this->faker->numberBetween(1, 5),
            'department_id' => fn () => Department::factory(),
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }

    public function unavailable()
    {
        return $this->state([
            'available' => 0,
        ]);
    }
}
