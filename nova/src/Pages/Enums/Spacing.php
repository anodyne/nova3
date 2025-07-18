<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum Spacing: string implements HasLabel
{
    case None = 'none';

    case ExtraSmall = 'xs';

    case Small = 'sm';

    case Medium = 'md';

    case Large = 'lg';

    case ExtraLarge = 'xl';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ExtraSmall => 'Extra small',
            self::Small => 'Small',
            self::Medium => 'Medium',
            self::Large => 'Large',
            self::ExtraLarge => 'Extra large',
            self::None => 'None',
        };
    }

    public function getHorizontalTailwindClasses(): ?string
    {
        return match ($this) {
            self::ExtraSmall => 'px-2',
            self::Small => 'px-4',
            self::Medium => 'px-8',
            self::Large => 'px-16',
            self::ExtraLarge => 'px-24',
            self::None => 'px-0',
        };
    }

    public function getVerticalTailwindClasses(): ?string
    {
        return match ($this) {
            self::ExtraSmall => 'py-2',
            self::Small => 'py-4',
            self::Medium => 'py-8',
            self::Large => 'py-16',
            self::ExtraLarge => 'py-24',
            self::None => 'py-0',
        };
    }
}
