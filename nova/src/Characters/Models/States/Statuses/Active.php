<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Statuses;

class Active extends CharacterStatus
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
