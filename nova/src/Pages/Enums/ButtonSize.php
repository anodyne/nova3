<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum ButtonSize: string implements HasLabel
{
    case Text = 'text';

    case ExtraSmall = 'xs';

    case Small = 'sm';

    case Medium = 'md';

    case Large = 'lg';

    case ExtraLarge = 'xl';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Text => 'Text only',
            self::ExtraSmall => 'Extra small',
            self::Small => 'Small',
            self::Medium => 'Medium',
            self::Large => 'Large',
            self::ExtraLarge => 'Extra large',
        };
    }

    public function getTailwindClasses(): ?string
    {
        return match ($this) {
            self::Text => 'px-0 py-0 text-sm/6 font-semibold',
            self::ExtraSmall => 'px-2 py-1 text-xs/5 font-semibold',
            self::Small => 'px-2 py-1 text-sm/6 font-semibold',
            self::Medium => 'px-2.5 py-1.5 text-sm/6 font-semibold',
            self::Large => 'px-3 py-2 text-sm/6 font-semibold',
            self::ExtraLarge => 'px-3.5 py-2.5 text-sm/6 font-semibold',
        };
    }
}
