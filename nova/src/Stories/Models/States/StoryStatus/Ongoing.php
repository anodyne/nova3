<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

class Ongoing extends StoryStatus
{
    public static $name = 'ongoing';

    public function color(): string
    {
        return 'success';
    }

    public function description(): string
    {
        return 'Active story or story arc that cannot be posted into';
    }

    public function textColor(): string
    {
        return 'text-success-500';
    }

    public function timelineMarker(): string
    {
        return 'bg-success-500 ring-white dark:ring-gray-900';
    }

    public function name(): string
    {
        return 'ongoing';
    }

    public function order(): int
    {
        return 2;
    }
}
