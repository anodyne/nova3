<?php

declare(strict_types=1);

namespace Nova\Stories\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum PostEditTimeframe: string implements HasLabel
{
    use HasSelectOptions;

    case Never = 'never';
    case Min5 = '5m';
    case Min15 = '15m';
    case Min30 = '30m';
    case Hour1 = '1h';
    case Hour2 = '2h';
    case Hour4 = '4h';
    case Hour6 = '6h';
    case Hour8 = '8h';
    case Hour12 = '12h';
    case Hour24 = '24h';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Min5 => '5 minutes',
            self::Min15 => '15 minutes',
            self::Min30 => '30 minutes',
            self::Hour1 => '1 hour',
            self::Hour2 => '2 hours',
            self::Hour4 => '4 hours',
            self::Hour6 => '6 hours',
            self::Hour8 => '8 hours',
            self::Hour12 => '12 hours',
            self::Hour24 => '24 hours',
            default => 'Not allowed to edit after publishing',
        };
    }
}
