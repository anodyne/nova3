<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

class Completed extends StoryStatus
{
    public static $name = 'completed';

    public function getColor(): string
    {
        return 'gray';
    }

    public function getDescription(): string
    {
        return 'Story or story arc that has concluded';
    }

    public function textColor(): string
    {
        return 'text-gray-400 dark:text-gray-500';
    }

    public function timelineMarker(): string
    {
        return 'before:text-gray-400 dark:before:text-gray-500';
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
