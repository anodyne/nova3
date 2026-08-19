<?php

declare(strict_types=1);

namespace Nova\Users\Enums;

use Anodyne\TablerIcons\Tabler;
use BackedEnum;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Appearance: string implements HasIcon, HasLabel
{
    case Dark = 'dark';
    case Light = 'light';

    public function getClasses(): ?string
    {
        return match ($this) {
            self::Dark => 'dark',
            default => null,
        };
    }

    public function getIcon(): BackedEnum
    {
        return match ($this) {
            self::Dark => Tabler::MoonStars,
            self::Light => Tabler::Sun,
        };
    }

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }
}
