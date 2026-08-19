<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum BoxShadow: string implements HasLabel
{
    case None = 'none';
    case TwoExtraSmall = '2xs';
    case ExtraSmall = 'xs';
    case Small = 'sm';
    case Medium = 'md';
    case Large = 'lg';
    case ExtraLarge = 'xl';
    case TwoExtraLarge = '2xl';
    case InsetNone = 'inset-none';
    case InsetExtraSmall = 'inset-xs';
    case InsetSmall = 'inset-sm';

    public function getLabel(): string
    {
        return match ($this) {
            self::None => 'None',
            self::TwoExtraSmall => 'Extra small 2x',
            self::ExtraSmall => 'Extra small',
            self::Small => 'Small',
            self::Medium => 'Medium',
            self::Large => 'Large',
            self::ExtraLarge => 'Extra large',
            self::TwoExtraLarge => 'Extra large 2x',
            self::InsetNone => 'No inset',
            self::InsetExtraSmall => 'Inset extra small',
            self::InsetSmall => 'Inset small',
        };
    }

    public function getTailwindClasses(): string
    {
        return match ($this) {
            self::None => 'shadow-none',
            self::TwoExtraSmall => 'shadow-2xs',
            self::ExtraSmall => 'shadow-xs',
            self::Small => 'shadow-sm',
            self::Medium => 'shadow-md',
            self::Large => 'shadow-lg',
            self::ExtraLarge => 'shadow-xl',
            self::TwoExtraLarge => 'shadow-2xl',
            self::InsetNone => 'inset-shadow-none',
            self::InsetExtraSmall => 'inset-shadow-xs',
            self::InsetSmall => 'inset-shadow-sm',
        };
    }
}
