<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

class Completed extends StoryStatus
{
    public function color(): string
    {
        return 'gray';
    }

    public function name(): string
    {
        return 'completed';
    }
}
