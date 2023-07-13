<?php

declare(strict_types=1);

namespace Nova\Characters\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum CharacterType: string implements HasLabel
{
    use HasSelectOptions;

    case primary = 'primary';

    case secondary = 'secondary';

    case support = 'support';

    public function color(): string
    {
        return match ($this) {
            self::primary => 'primary',
            self::secondary => 'info',
            self::support => 'gray',
        };
    }

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
