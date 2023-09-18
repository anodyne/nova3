<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

class Completed extends StoryStatus
{
    public static $name = 'completed';

    public function color(): string
    {
        return 'gray';
    }

    public function description(): string
    {
        return 'Story or story arc that has concluded';
    }

    public function textColor(): string
    {
        return 'text-gray-400 dark:text-gray-500';
    }

    public function timelineMarker(): string
    {
        return 'bg-gray-400 dark:bg-gray-500 ring-white dark:ring-gray-900';
    }

    public function name(): string
    {
        return 'completed';
    }

    public function order(): int
    {
        return 4;
    }
}
