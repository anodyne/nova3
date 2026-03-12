<?php

declare(strict_types=1);

namespace Nova\Users\Enums;

use Anodyne\TablerIcons\Tabler;
use BackedEnum;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Appearance: string implements HasIcon, HasLabel
{
    case Light = 'light';

    case Dark = 'dark';

    public function getClasses(): ?string
    {
        return match ($this) {
            self::Dark => 'dark',
            default => null,
        };
    }

    public function getIcon(): string|BackedEnum|null
    {
        return match ($this) {
            self::Dark => Tabler::MoonStars,
            self::Light => Tabler::Sun,
        };
    }

    public function getLabel(): string|Htmlable|null
    {
        return ucfirst($this->value);
    }
}
