<?php

declare(strict_types=1);

namespace Nova\Setup\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UpdateSeverity: string implements HasColor, HasLabel
{
    case Major = 'major';

    case Minor = 'minor';

    case Patch = 'patch';

    case Security = 'security';

    case Critical = 'critical';

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Major => 'primary',
            self::Minor => 'info',
            self::Security, self::Critical => 'danger',
            default => 'gray',
        };
    }
}
