<?php

declare(strict_types=1);

namespace Nova\Posts\Models\States;

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
