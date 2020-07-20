<?php

namespace Nova\Stories\Models\States\Stories;

class Completed extends StoryStatus
{
    public function color(): string
    {
        return '';
    }

    public function name(): string
    {
        return 'completed';
    }
}
