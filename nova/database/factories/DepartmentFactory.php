<?php


namespace Database\Factories;

use Nova\Departments\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word),
            'description' => $this->faker->sentence,
            'sort' => 0,
            'active' => true,
        ];
    }

    public function inactive()
    {
        return $this->state([
            'active' => false,
        ]);
    }
}
