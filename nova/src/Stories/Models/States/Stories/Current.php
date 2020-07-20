<?php

namespace Nova\Stories\Models\States\Stories;

class Current extends StoryStatus
{
    public function color(): string
    {
        return 'primary';
    }

    public function name(): string
    {
        return 'current';
    }
}
