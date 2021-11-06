<?php

declare(strict_types=1);

namespace Nova\Users\Models\States;

class Inactive extends UserStatus
{
    public static $name = 'inactive';

    public function color(): string
    {
        return 'gray';
    }

    public function name(): string
    {
        return 'inactive';
    }
}
