<?php

declare(strict_types=1);

namespace Nova\Characters\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum CharacterType: string implements HasLabel
{
    use HasSelectOptions;

    case Primary = 'primary';

    case Secondary = 'secondary';

    case Support = 'support';

    public function color(): string
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
