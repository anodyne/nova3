<?php

declare(strict_types=1);

namespace Nova\Users\Models\States\Status;

class Active extends UserStatus
{
    public static $name = 'active';

    public function simple(): string
    {
        return 'Existing user';
    }

    public function color(): string
    {
        return 'success';
    }

    public function bgColor(): string
    {
        return 'bg-success-500';
    }

    public function name(): string
    {
        return 'active';
    }
}
