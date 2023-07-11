<?php

declare(strict_types=1);

namespace Nova\Characters\Enums;

use Filament\Support\Contracts\HasLabel;

enum CharacterType: string implements HasLabel
{
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

    public static function toOptions(): array
    {
        return collect(self::cases())
            ->flatMap(fn ($case) => [$case->value => $case->getLabel()])
            ->all();
    }
}
