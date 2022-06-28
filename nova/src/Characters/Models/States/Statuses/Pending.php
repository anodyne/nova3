<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Statuses;

class Pending extends CharacterStatus
{
    public static $name = 'pending';

    public function color(): string
    {
        return 'warning';
    }

    public function bgColor(): string
    {
        return "bg-{$this->color()}-500";
    }

    public function name(): string
    {
        return 'pending';
    }
}
