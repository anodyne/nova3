<?php

namespace Database\Factories;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition()
    {
        return [
            'name' => ucwords($this->faker->words($this->faker->numberBetween(1, 3), true)),
            'description' => $this->faker->sentence,
            'active' => true,
            'available' => $this->faker->numberBetween(1, 5),
            'department_id' => fn () => Department::factory(),
        ];
    }

    public function inactive()
    {
        return $this->state([
            'active' => false,
        ]);
    }

    public function unavailable()
    {
        return $this->state([
            'available' => 0,
        ]);
    }
}
