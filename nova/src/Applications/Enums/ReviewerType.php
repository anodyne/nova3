<?php

declare(strict_types=1);

namespace Nova\Applications\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ReviewerType: string implements HasColor, HasLabel
{
    case Global = 'global';
    case Conditional = 'conditional';

    public function bgColor(): string
    {
        return match ($this) {
            self::Global => 'bg-primary-500',
            self::Conditional => 'bg-info-500',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Global => 'primary',
            self::Conditional => 'info',
        };
    }

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }
}
