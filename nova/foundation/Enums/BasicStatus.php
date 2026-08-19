<?php

declare(strict_types=1);

namespace Nova\Foundation\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BasicStatus: string implements HasColor, HasLabel
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Pending = 'pending';

    public function bgColor(): string
    {
        return match ($this) {
            self::Active => 'bg-success-500',
            self::Inactive => 'bg-gray-500',
            self::Pending => 'bg-warning-500',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
            self::Pending => 'warning',
        };
    }

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }

    public static function options(bool $withPending = false): array
    {
        return collect(self::cases())
            ->unless($withPending, fn ($collection) => $collection->reject(fn ($case) => $case === self::Pending))
            ->toArray();
    }
}
