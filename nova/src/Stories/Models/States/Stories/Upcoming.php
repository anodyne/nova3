<?php

namespace Nova\Stories\Models\States\Stories;

class Upcoming extends StoryStatus
{
    public function color(): string
    {
        return 'warning';
    }

    public function name(): string
    {
        return 'upcoming';
    }
}
