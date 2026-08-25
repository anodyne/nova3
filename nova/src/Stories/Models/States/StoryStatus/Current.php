<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

class Current extends StoryStatus
{
    public static string $name = 'current';

    public function getColor(): string
    {
        return 'primary';
    }

    public function getDescription(): string
    {
        return 'Story that is currently running and players can post into';
    }

    public function textColor(): string
    {
        return 'text-primary-500';
    }

    public function timelineMarker(): string
    {
        return 'before:text-primary-500';
    }

    public function name(): string
    {
        return 'current';
    }

    public function order(): int
    {
        return 3;
    }
}
