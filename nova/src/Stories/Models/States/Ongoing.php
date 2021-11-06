<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

class Ongoing extends StoryStatus
{
    public static $name = 'ongoing';

    public function color(): string
    {
        return 'green';
    }

    public function name(): string
    {
        return 'ongoing';
    }
}
