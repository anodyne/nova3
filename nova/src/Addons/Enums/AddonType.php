<?php

declare(strict_types=1);

namespace Nova\Addons\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AddonType: string implements HasColor, HasLabel
{
    case Extension = 'extension';
    case Genre = 'genre';
    case Rank = 'rank';

    public function bgColor(): string
    {
        return match ($this) {
            self::Extension => 'bg-success-500',
            self::Genre => 'bg-primary-500',
            self::Rank => 'bg-warning-500',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Extension => 'success',
            self::Genre => 'primary',
            self::Rank => 'warning',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Extension => 'Extension',
            self::Genre => 'Genre',
            self::Rank => 'Rank set',
        };
    }
}
