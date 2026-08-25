<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Themes\Models\Theme;

/** @extends Factory<Theme> */
class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition(): array
    {
        $name = rtrim($this->faker->sentence(mt_rand(1, 3), variableNbWords: false), '.');

        return [
            'name' => ucfirst($name),
            'location' => Str::slug($name),
            'status' => BasicStatus::Active,
            'preview' => 'preview.jpg',
            'version' => '1.0',
            'settings' => [
                'fonts' => [
                    'headerProvider' => '',
                    'headerFamily' => '',
                    'bodyProvider' => '',
                    'bodyFamily' => '',
                    'monoProvider' => 'local',
                    'monoFamily' => 'Monaspace Neon',
                ],
            ],
        ];
    }

    public function inactive(): static
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }
}
