<?php

declare(strict_types=1);

namespace Nova\Foundation\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PublishStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';

    case Pending = 'pending';

    case Published = 'published';

    public function bgColor(): string
    {
        return match ($this) {
            self::Draft => 'bg-gray-500',
            self::Pending => 'bg-warning-500',
            self::Published => 'bg-success-500',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Pending => 'warning',
            self::Published => 'success',
        };
    }

    public function getLabel(): ?string
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
