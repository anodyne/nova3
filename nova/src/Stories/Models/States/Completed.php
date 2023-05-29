<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States;

class Completed extends StoryStatus
{
    public static $name = 'completed';

    public function color(): string
    {
        return 'gray';
    }

    public function textColor(): string
    {
        return "text-gray-400 dark:text-gray-500";
    }

    public function name(): string
    {
        return 'completed';
    }
}
