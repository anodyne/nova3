<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Themes\Models\Theme;

/**
 * @extends Factory<Model>
 */
class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition(): array
    {
        $name = $this->faker->words(mt_rand(1, 3), true);

        return [
            'name' => ucfirst($name),
            'location' => Str::slug($name),
            'status' => BasicStatus::Active,
            'preview' => 'preview.jpg',
        ];
    }

    public function inactive(): static
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }
}
