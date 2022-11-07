<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\States\Departments\Active;
use Nova\Departments\Models\States\Departments\Inactive;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word),
            'description' => $this->faker->sentence,
            'sort' => 0,
            'status' => 'active',
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => 'inactive',
        ]);
    }
}
