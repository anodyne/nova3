<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

class Pending extends PostStatus
{
    public static $name = 'pending';

    public function color(): string
    {
        return 'warning';
    }

    public function name(): string
    {
        return 'pending';
    }
}
