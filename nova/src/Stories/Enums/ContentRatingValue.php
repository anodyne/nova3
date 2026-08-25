<?php

declare(strict_types=1);

namespace Nova\Stories\Enums;

use Filament\Support\Contracts\HasLabel;

enum ContentRatingValue: string implements HasLabel
{
    case Game = 'game';
    case Level0 = '0';
    case Level1 = '1';
    case Level2 = '2';
    case Level3 = '3';
    case None = 'none';

    public function getLabel(): string
    {
        return $this->value;
    }

    public function getLabelForThreshold(): string
    {
        return match ($this) {
            self::Game => 'Follow game',
            self::None => 'Never warn',
            default => $this->value,
        };
    }

    /** @return array<int, self> */
    public static function casesForGameThreshold(): array
    {
        return array_filter(self::cases(), fn (ContentRatingValue $case): bool => $case !== self::Game);
    }

    /** @return array<int, self> */
    public static function casesForRatings(): array
    {
        return array_filter(self::cases(), fn (ContentRatingValue $case): bool => ! in_array($case, [self::Game, self::None], true));
    }

    /** @return list<self> */
    public static function casesForUserThreshold(): array
    {
        return self::cases();
    }
}
