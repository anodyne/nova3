<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nova\Themes\Models\Theme;

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
            'preview' => 'preview.jpg',
        ];
    }

    public function inactive()
    {
        return $this->state([
            'active' => false,
        ]);
    }
}
