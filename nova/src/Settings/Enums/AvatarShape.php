<?php

declare(strict_types=1);

namespace Nova\Settings\Enums;

use Anodyne\TablerIcons\Tabler;
use BackedEnum;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum AvatarShape: string implements HasIcon, HasLabel
{
    use HasSelectOptions;

    case Circle = 'circle';
    case Square = 'square';
    case Squircle = 'squircle';

    public function getIcon(): BackedEnum
    {
        return match ($this) {
            self::Circle => Tabler::Circle,
            self::Square => Tabler::Square,
            self::Squircle => Tabler::SquareRounded,
        };
    }

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }
}
