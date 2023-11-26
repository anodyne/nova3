<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

class Started extends PostStatus
{
    public static $name = 'started';

    public function color(): string
    {
        return 'gray';
    }

    public function name(): string
    {
        return 'started';
    }
}
