<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum BackgroundImageIntensity: string implements HasLabel
{
    case None = 'none';

    case Intense = 'intense';

    case Vivid = 'vivid';

    case Neutral = 'neutral';

    case Muted = 'muted';

    case Subtle = 'subtle';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::None => 'No overlay',
            default => ucfirst($this->value),
        };
    }

    public function getTailwindClasses(): ?string
    {
        return match ($this) {
            self::None => 'bg-opacity-0 dark:bg-opacity-0',
            self::Intense => 'bg-opacity-20 dark:bg-opacity-20',
            self::Vivid => 'bg-opacity-40 dark:bg-opacity-40',
            self::Neutral => 'bg-opacity-50 dark:bg-opacity-50',
            self::Muted => 'bg-opacity-60 dark:bg-opacity-60',
            self::Subtle => 'bg-opacity-80 dark:bg-opacity-80',
        };
    }
}
