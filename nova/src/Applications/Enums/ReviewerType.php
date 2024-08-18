<?php

declare(strict_types=1);

namespace Nova\Applications\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum ReviewerType: string implements HasLabel
{
    use HasSelectOptions;

    case Global = 'global';

    case Conditional = 'conditional';

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }

    public function bgColor(): string
    {
        return match ($this) {
            self::Global => 'bg-primary-500',
            self::Conditional => 'bg-info-500',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Global => 'primary',
            self::Conditional => 'info',
        };
    }
}
