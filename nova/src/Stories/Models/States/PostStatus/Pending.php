<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

class Pending extends PostStatus
{
    public static string $name = 'pending';

    public function getColor(): string
    {
        return 'warning';
    }

    public function name(): string
    {
        return 'pending';
    }
}
