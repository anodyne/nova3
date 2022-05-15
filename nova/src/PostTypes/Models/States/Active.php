<?php

declare(strict_types=1);

namespace Nova\PostTypes\Models\States;

class Active extends PostTypeStatus
{
    public static $name = 'active';

    public function color(): string
    {
        return 'green';
    }

    public function bgColor(): string
    {
        return "bg-{$this->color()}-500";
    }

    public function name(): string
    {
        return 'active';
    }
}
