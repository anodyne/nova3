<?php

declare(strict_types=1);

namespace Nova\Users\Models\States;

class Pending extends UserStatus
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
