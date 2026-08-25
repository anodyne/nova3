<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nova\Roles\Models\Role;

/** @extends Factory<Role> */
class RoleFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = Role::class;

    public function default(): static
    {
        return $this->state([
            'is_default' => true,
        ]);
    }

    public function definition(): array
    {
        $name = rtrim($this->faker->sentence(4, variableNbWords: false), '.');

        return [
            'name' => Str::slug($name),
            'display_name' => $name,
            'is_locked' => false,
            'is_default' => false,
        ];
    }

    public function locked(): static
    {
        return $this->state([
            'is_locked' => true,
        ]);
    }

    public function notDefault(): static
    {
        return $this->state([
            'is_default' => false,
        ]);
    }
}
