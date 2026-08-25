<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

class Upcoming extends StoryStatus
{
    public static string $name = 'upcoming';

    public function getColor(): string
    {
        return 'info';
    }

    public function getDescription(): string
    {
        return 'Story or story arc that will happen in the future';
    }

    public function textColor(): string
    {
        return 'text-info-500';
    }

    public function timelineMarker(): string
    {
        return 'before:text-info-500';
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
