<?php

declare(strict_types=1);

namespace Nova\Foundation\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ReleaseSeverity: string implements HasColor, HasLabel
{
    case Major = 'major';

    case Minor = 'minor';

    case Patch = 'patch';

    case Critical = 'critical';

    case Security = 'security';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Critical => 'danger',
            self::Security => 'danger',
            self::Minor => 'primary',
            self::Major => 'info',
            default => 'gray',
        };
    }

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
