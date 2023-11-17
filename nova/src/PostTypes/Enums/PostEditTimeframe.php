<?php

declare(strict_types=1);

namespace Nova\PostTypes\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum PostEditTimeframe: string implements HasLabel
{
    use HasSelectOptions;

    case never = 'never';
    case min5 = '5m';
    case min15 = '15m';
    case min30 = '30m';
    case hour1 = '1h';
    case hour2 = '2h';
    case hour4 = '4h';
    case hour6 = '6h';
    case hour8 = '8h';
    case hour12 = '12h';
    case hour24 = '24h';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::min5 => '5 minutes',
            self::min15 => '15 minutes',
            self::min30 => '30 minutes',
            self::hour1 => '1 hour',
            self::hour2 => '2 hours',
            self::hour4 => '4 hours',
            self::hour6 => '6 hours',
            self::hour8 => '8 hours',
            self::hour12 => '12 hours',
            self::hour24 => '24 hours',
            default => 'Not allowed to edit after publishing',
        };
    }
}
