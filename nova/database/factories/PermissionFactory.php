<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Roles\Models\Permission;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition()
    {
        $word = $this->faker->word();

        return [
            'name' => $word,
            'display_name' => ucfirst($word),
            'description' => null,
        ];
    }
}
