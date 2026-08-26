<?php

declare(strict_types=1);

namespace Database\Factories;

use Nova\Foundation\Enums\BasicStatus;
use Nova\Themes\Models\PendingTheme;

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
