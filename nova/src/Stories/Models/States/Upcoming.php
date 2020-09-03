<?php

namespace Nova\Stories\Models\States;

class Upcoming extends StoryStatus
{
    public function color(): string
    {
        return 'yellow';
    }

    public function name(): string
    {
        return 'upcoming';
    }
}
