<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Departments\Enums\DepartmentStatus;
use Nova\Departments\Models\Department;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word),
            'description' => $this->faker->sentence,
            'sort' => 0,
            'status' => DepartmentStatus::active,
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => DepartmentStatus::inactive,
        ]);
    }
}
