<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

class Ongoing extends StoryStatus
{
    public static $name = 'ongoing';

    public function color(): string
    {
        return 'success';
    }

    public function textColor(): string
    {
        return "text-success-500";
    }

    public function name(): string
    {
        return 'ongoing';
    }
}
