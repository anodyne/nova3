<?php

declare(strict_types=1);

namespace Nova\Posts\Models\States;

class Pending extends PostStatus
{
    public static $name = 'pending';

    public function color(): string
    {
        return 'yellow';
    }

    public function name(): string
    {
        return 'pending';
    }
}
