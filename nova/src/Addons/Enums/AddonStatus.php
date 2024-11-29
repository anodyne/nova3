<?php

declare(strict_types=1);

namespace Nova\Addons\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum AddonStatus: string implements HasColor, HasLabel
{
    use HasSelectOptions;

    case Active = 'active';

    case Inactive = 'inactive';

    public function bgColor(): string
    {
        return match ($this) {
            self::Active => 'bg-success-500',
            self::Inactive => 'bg-gray-500',
        };
    }

    public function getColor(): string
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
