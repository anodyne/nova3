<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum Blur: string implements HasLabel
{
    case None = 'none';

    case ExtraSmall = 'xs';

    case Small = 'sm';

    case Medium = 'md';

    case Large = 'lg';

    case ExtraLarge = 'xl';

    case TwoExtraLarge = '2xl';

    case ThreeExtraLarge = '3xl';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::None => 'None',
            self::ExtraSmall => 'Extra small (4px)',
            self::Small => 'Small (8px)',
            self::Medium => 'Medium (12px)',
            self::Large => 'Large (16px)',
            self::ExtraLarge => 'Extra large (24px)',
            self::TwoExtraLarge => 'Extra large 2x (40px)',
            self::ThreeExtraLarge => 'Extra large 3x (64px)',
        };
    }

    public function getTailwindClasses(): ?string
    {
        return match ($this) {
            self::None => 'backdrop-blur-none',
            self::ExtraSmall => 'backdrop-blur-xs',
            self::Small => 'backdrop-blur-sm',
            self::Medium => 'backdrop-blur-md',
            self::Large => 'backdrop-blur-lg',
            self::ExtraLarge => 'backdrop-blur-xl',
            self::TwoExtraLarge => 'backdrop-blur-2xl',
            self::ThreeExtraLarge => 'backdrop-blur-3xl',
        };
    }
}
