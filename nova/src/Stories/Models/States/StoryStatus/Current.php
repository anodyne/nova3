<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

class Current extends StoryStatus
{
    public static $name = 'current';

    public function color(): string
    {
        return 'primary';
    }

    public function description(): string
    {
        return 'Story that is currently running and players can post into';
    }

    public function textColor(): string
    {
        return 'text-primary-500';
    }

    public function timelineMarker(): string
    {
        return 'bg-primary-500 ring-primary-500';
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
