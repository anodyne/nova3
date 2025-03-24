<?php

declare(strict_types=1);

namespace Nova\Users\Models\States\Status;

class Banned extends UserStatus
{
    public static $name = 'banned';

    public function simple(): string
    {
        return 'Banned user';
    }

    public function getColor(): string
    {
        return 'danger';
    }

    public function bgColor(): string
    {
        return 'bg-danger-500';
    }

    public function name(): string
    {
        return 'banned';
    }
}
