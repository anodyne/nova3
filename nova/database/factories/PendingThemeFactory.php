<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Themes\Models\PendingTheme;

/** @extends Factory<PendingTheme> */
class PendingThemeFactory extends ThemeFactory
{
    protected $model = PendingTheme::class;

    public function definition(): array
    {
        return [
            ...parent::definition(),
            'status' => BasicStatus::Pending,
        ];
    }
}
