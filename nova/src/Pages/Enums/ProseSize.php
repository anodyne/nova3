<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProseSize: string implements HasLabel
{
    case Small = 'sm';

    case Base = 'base';

    case Large = 'lg';

    case ExtraLarge = 'xl';

    case TwoExtraLarge = '2xl';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Small => 'Small',
            self::Base => 'Medium',
            self::Large => 'Large',
            self::ExtraLarge => 'Extra large',
            self::TwoExtraLarge => 'Extra large 2x',
        };
    }

    public function getTailwindClasses(): ?string
    {
        return match ($this) {
            self::Small => 'prose-sm',
            self::Base => 'prose-base',
            self::Large => 'prose-lg',
            self::ExtraLarge => 'prose-xl',
            self::TwoExtraLarge => 'prose-2xl',
        };
    }
}
