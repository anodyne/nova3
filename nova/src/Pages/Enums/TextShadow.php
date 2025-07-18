<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum TextShadow: string implements HasLabel
{
    case None = 'none';

    case TwoExtraSmall = '2xs';

    case ExtraSmall = 'xs';

    case Small = 'sm';

    case Medium = 'md';

    case Large = 'lg';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::None => 'None',
            self::TwoExtraSmall => 'Extra small 2x',
            self::ExtraSmall => 'Extra small',
            self::Small => 'Small',
            self::Medium => 'Medium',
            self::Large => 'Large',
        };
    }

    public function getTailwindClasses(): ?string
    {
        return match ($this) {
            self::None => 'text-shadow-none',
            self::TwoExtraSmall => 'text-shadow-2xs',
            self::ExtraSmall => 'text-shadow-xs',
            self::Small => 'text-shadow-sm',
            self::Medium => 'text-shadow-md',
            self::Large => 'text-shadow-lg',
        };
    }
}
