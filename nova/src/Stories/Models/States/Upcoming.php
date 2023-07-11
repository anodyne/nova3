<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

class Upcoming extends StoryStatus
{
    public static $name = 'upcoming';

    public function color(): string
    {
        return 'info';
    }

    public function textColor(): string
    {
        return 'text-info-500';
    }

    public function name(): string
    {
        return 'upcoming';
    }
}
