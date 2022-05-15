<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

class Upcoming extends StoryStatus
{
    public static $name = 'upcoming';

    public function color(): string
    {
        return 'yellow';
    }

    public function textColor(): string
    {
        return "text-{$this->color()}-500";
    }

    public function name(): string
    {
        return 'upcoming';
    }
}
