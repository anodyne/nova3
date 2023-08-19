<?php

declare(strict_types=1);

namespace Nova\Ranks\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum RankItemStatus: string implements HasLabel
{
    use HasSelectOptions;

    case active = 'active';

    case inactive = 'inactive';

    public function bgColor(): string
    {
        return match ($this) {
            self::active => 'bg-success-500',
            self::inactive => 'bg-gray-500',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::active => 'success',
            self::inactive => 'gray',
        };
    }

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
