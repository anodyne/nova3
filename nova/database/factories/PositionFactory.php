<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition()
    {
        return [
            'name' => ucwords($this->faker->words($this->faker->numberBetween(1, 3), true)),
            'description' => $this->faker->sentence,
            'status' => PositionStatus::active,
            'available' => $this->faker->numberBetween(1, 5),
            'department_id' => fn () => Department::factory(),
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => PositionStatus::inactive,
        ]);
    }

    public function unavailable()
    {
        return $this->state([
            'available' => 0,
        ]);
    }
}
