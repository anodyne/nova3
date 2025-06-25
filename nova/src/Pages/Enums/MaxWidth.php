<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum MaxWidth: string implements HasLabel
{
    case ExtraSmall = 'xs';

    case Small = 'sm';

    case Medium = 'md';

    case Large = 'lg';

    case ExtraLarge = 'xl';

    case TwoExtraLarge = '2xl';

    case ThreeExtraLarge = '3xl';

    case FourExtraLarge = '4xl';

    case FiveExtraLarge = '5xl';

    case SixExtraLarge = '6xl';

    case SevenExtraLarge = '7xl';

    case Full = 'full';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ExtraSmall => 'Extra small (320px)',
            self::Small => 'Small (384px)',
            self::Medium => 'Medium (448px)',
            self::Large => 'Large (512px)',
            self::ExtraLarge => 'Extra large (576px)',
            self::TwoExtraLarge => 'Extra large x2 (672px)',
            self::ThreeExtraLarge => 'Extra large x3 (768px)',
            self::FourExtraLarge => 'Extra large x4 (896px)',
            self::FiveExtraLarge => 'Extra large x5 (1024px)',
            self::SixExtraLarge => 'Extra large x6 (1152px)',
            self::SevenExtraLarge => 'Extra large x7 (1280px)',
            default => 'Full width',
        };
    }

    public function getTailwindClasses(): ?string
    {
        return 'max-w-'.$this->value;
    }
}
