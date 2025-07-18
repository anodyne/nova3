<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\StoryStatus;

class Ongoing extends StoryStatus
{
    public static $name = 'ongoing';

    public function getColor(): string
    {
        return 'success';
    }

    public function getDescription(): string
    {
        return 'Active story or story arc that cannot be posted into';
    }

    public function textColor(): string
    {
        return 'text-success-500';
    }

    public function timelineMarker(): string
    {
        return 'before:text-success-500';
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
