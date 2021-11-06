<?php

declare(strict_types=1);

namespace Nova\Users\Models\States;

class Active extends UserStatus
{
    public static $name = 'active';

    public function color(): string
    {
        return 'green';
    }

    public function name(): string
    {
        return 'active';
    }
}
