<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

class Current extends StoryStatus
{
    public function color(): string
    {
        return 'blue';
    }

    public function name(): string
    {
        return 'current';
    }
}
