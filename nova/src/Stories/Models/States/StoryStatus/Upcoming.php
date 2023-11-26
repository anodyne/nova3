<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

class Upcoming extends StoryStatus
{
    public static $name = 'upcoming';

    public function color(): string
    {
        return 'info';
    }

    public function description(): string
    {
        return 'Story or story arc that will happen in the future';
    }

    public function textColor(): string
    {
        return 'text-info-500';
    }

    public function timelineMarker(): string
    {
        return 'bg-info-500 ring-white dark:ring-gray-900';
    }

    public function name(): string
    {
        return 'upcoming';
    }

    public function order(): int
    {
        return 1;
    }
}
