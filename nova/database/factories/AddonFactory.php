<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nova\Addons\Enums\AddonStatus;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Models\Addon;
use Nova\Themes\Enums\ThemeStatus;

class AddonFactory extends Factory
{
    protected $model = Addon::class;

    public function definition()
    {
        $name = $this->faker->words(mt_rand(1, 3), asText: true);

        return [
            'name' => ucfirst($name),
            'location' => Str::studly($name),
            'version' => '1.0',
            'status' => AddonStatus::Active,
            'type' => $this->faker->randomElement(AddonType::cases()),
            'preview' => 'preview.jpg',
        ];
    }

    public function inactive()
    {
        return $this->state([
            'status' => ThemeStatus::Inactive,
        ]);
    }
}
