<?php

declare(strict_types=1);

namespace Nova\Foundation\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BasicStatus: string implements HasColor, HasLabel
{
    case Active = 'active';

    case Inactive = 'inactive';

    public function bgColor(): string
    {
        return match ($this) {
            self::Active => 'bg-success-500',
            self::Inactive => 'bg-gray-500',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
        };
    }

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
