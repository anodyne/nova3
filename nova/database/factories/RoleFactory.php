<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Nova\Roles\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        $name = $this->faker->words(2, true);

        return [
            'name' => Str::slug($name),
            'display_name' => $name,
            'locked' => false,
            'default' => false,
        ];
    }

    public function default()
    {
        return $this->state([
            'default' => true,
        ]);
    }

    public function locked()
    {
        return $this->state([
            'locked' => true,
        ]);
    }
}
