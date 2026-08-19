<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum Radius: string implements HasLabel
{
    case None = 'none';
    case ExtraSmall = 'xs';
    case Small = 'sm';
    case Medium = 'md';
    case Large = 'lg';
    case ExtraLarge = 'xl';
    case TwoExtraLarge = '2xl';
    case ThreeExtraLarge = '3xl';
    case FourExtraLarge = '4xl';
    case Full = 'full';

    public function getLabel(): string
    {
        return match ($this) {
            self::None => 'None',
            self::ExtraSmall => 'Extra small (2px)',
            self::Small => 'Small (4px)',
            self::Medium => 'Medium (6px)',
            self::Large => 'Large (8px)',
            self::ExtraLarge => 'Extra large (12px)',
            self::TwoExtraLarge => 'Extra large 2x (16px)',
            self::ThreeExtraLarge => 'Extra large 3x (24px)',
            self::FourExtraLarge => 'Extra large 4x (32px)',
            self::Full => 'Fully rounded',
        };
    }

    public function getRawValue(): string
    {
        return match ($this) {
            self::None => '0',
            self::ExtraSmall => '0.125rem',
            self::Small => '0.25rem',
            self::Medium => '0.375rem',
            self::Large => '0.5rem',
            self::ExtraLarge => '0.75rem',
            self::TwoExtraLarge => '1rem',
            self::ThreeExtraLarge => '1.5rem',
            self::FourExtraLarge => '2rem',
            self::Full => '9999px',
        };
    }

    public function getTailwindClasses(): string
    {
        return match ($this) {
            self::None => 'rounded-none',
            self::ExtraSmall => 'rounded-xs',
            self::Small => 'rounded-sm',
            self::Medium => 'rounded-md',
            self::Large => 'rounded-lg',
            self::ExtraLarge => 'rounded-xl',
            self::TwoExtraLarge => 'rounded-2xl',
            self::ThreeExtraLarge => 'rounded-3xl',
            self::FourExtraLarge => 'rounded-4xl',
            self::Full => 'rounded-full',
        };
    }
}
