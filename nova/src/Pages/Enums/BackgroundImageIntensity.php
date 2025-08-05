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
            self::None => 'bg-white/0 dark:bg-black/0',
            self::Intense => 'bg-white/20 dark:bg-black/20',
            self::Vivid => 'bg-white/40 dark:bg-black/40',
            self::Neutral => 'bg-white/50 dark:bg-black/50',
            self::Muted => 'bg-white/60 dark:bg-black/60',
            self::Subtle => 'bg-white/80 dark:bg-black/80',
        };
    }
}
