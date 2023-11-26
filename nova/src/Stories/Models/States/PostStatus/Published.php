<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

class Published extends PostStatus
{
    public static $name = 'published';

    public function color(): string
    {
        return 'primary';
    }

    public function name(): string
    {
        return 'published';
    }
}
