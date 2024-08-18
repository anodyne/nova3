<?php

declare(strict_types=1);

namespace Nova\Users\Models\States\Status;

class Inactive extends UserStatus
{
    public static $name = 'inactive';

    public function simple(): string
    {
        return 'Previous user';
    }

    public function color(): string
    {
        return 'gray';
    }

    public function bgColor(): string
    {
        return 'bg-gray-400 dark:bg-gray-500';
    }

    public function name(): string
    {
        return 'inactive';
    }
}
