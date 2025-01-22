<?php

declare(strict_types=1);

namespace Nova\Menus\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum LinkType: string implements HasColor, HasLabel
{
    use HasSelectOptions;

    case Page = 'page';

    case Url = 'url';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Page => 'primary',
            self::Url => 'info',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Url => 'URL',
            default => ucfirst($this->value),
        };
    }
}
