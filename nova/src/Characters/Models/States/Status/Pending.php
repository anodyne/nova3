<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Status;

class Pending extends CharacterStatus
{
    public static $name = 'pending';

    public function color(): string
    {
        return 'warning';
    }

    public function bgColor(): string
    {
        return 'bg-warning-500';
    }

    public function name(): string
    {
        return 'pending';
    }
}
