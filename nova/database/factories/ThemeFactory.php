<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Nova\Themes\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition()
    {
        $name = $this->faker->words(mt_rand(1, 3), true);

        return [
            'name' => ucfirst($name),
            'location' => Str::slug($name),
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
