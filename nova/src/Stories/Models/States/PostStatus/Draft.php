<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

class Draft extends PostStatus
{
    public static $name = 'draft';

    public function color(): string
    {
        return 'gray';
    }

    public function name(): string
    {
        return 'draft';
    }
}
