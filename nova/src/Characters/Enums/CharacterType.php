<?php

declare(strict_types=1);

namespace Nova\Characters\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CharacterType: string implements HasColor, HasLabel
{
    case Primary = 'primary';

    case Secondary = 'secondary';

    case Support = 'support';

    public function getColor(): string
    {
        return match ($this) {
            self::Primary => 'primary',
            self::Secondary => 'info',
            self::Support => 'gray',
        };
    }

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
