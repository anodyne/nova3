<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ButtonDecoration: string implements HasLabel
{
    case None = 'none';

    case Arrow = 'arrow';

    case SingleChevron = 'single-chevron';

    case DoubleChevron = 'double-chevron';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::SingleChevron => 'Single chevron',
            self::DoubleChevron => 'Double chevron',
            default => ucfirst($this->value),
        };
    }

    public function getHtml(): ?string
    {
        return match ($this) {
            self::Arrow => '→',
            self::SingleChevron => '&rsaquo;',
            self::DoubleChevron => '&raquo;',
            default => null,
        };
    }
}
