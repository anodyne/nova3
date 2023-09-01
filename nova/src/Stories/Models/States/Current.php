<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

class Current extends StoryStatus
{
    public static $name = 'current';

    public function color(): string
    {
        return 'primary';
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
}
