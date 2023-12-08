<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nova\Roles\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        $name = $this->faker->words(2, true);

        return [
            'name' => Str::slug($name),
            'display_name' => $name,
            'is_locked' => false,
            'is_default' => false,
        ];
    }

    public function default()
    {
        return $this->state([
            'is_default' => true,
        ]);
    }

    public function locked()
    {
        return $this->state([
            'is_locked' => true,
        ]);
    }
}
