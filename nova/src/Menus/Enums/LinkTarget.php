<?php

declare(strict_types=1);

namespace Nova\Menus\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum LinkTarget: string implements HasLabel
{
    use HasSelectOptions;

    case Self = '_self';

    case Blank = '_blank';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Self => 'Same tab',
            self::Blank => 'New tab',
        };
    }
}
