<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Departments\Models\Department;
use Nova\Foundation\Enums\BasicStatus;

/** @extends Factory<Department> */
class DepartmentFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = Department::class;

    public function active(): static
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->word),
            'description' => $this->faker->sentence,
            'status' => BasicStatus::Active,
        ];
    }

    public function inactive(): static
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }
}
