<?php

declare(strict_types=1);

namespace Nova\Stories\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PostSorting: string implements HasLabel
{
    case PublishedAscending = 'published_at_ascending';
    case PublishedDescending = 'published_at_descending';
    case TimelineAscending = 'timeline_ascending';
    case TimelineDescending = 'timeline_descending';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::PublishedAscending => 'Publish date ascending',
            self::PublishedDescending => 'Publish date descending',
            self::TimelineAscending => 'Story order ascending',
            self::TimelineDescending => 'Story order descending',
        };
    }

    public function getSortColumn(): string
    {
        return match ($this) {
            self::PublishedAscending, self::PublishedDescending => 'published_at',
            self::TimelineAscending, self::TimelineDescending => 'order_column',
        };
    }

    public function getSortDirection(): string
    {
        return match ($this) {
            self::PublishedAscending, self::TimelineAscending => 'asc',
            self::PublishedDescending, self::TimelineDescending => 'desc',
        };
    }
}
