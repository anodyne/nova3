<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

class Published extends PostStatus
{
    public static string $name = 'published';

    public function getColor(): string
    {
        return 'primary';
    }

    public function name(): string
    {
        return 'published';
    }
}
