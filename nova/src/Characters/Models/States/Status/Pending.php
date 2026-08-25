<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Status;

class Pending extends CharacterStatus
{
    public static string $name = 'pending';

    public function bgColor(): string
    {
        return 'bg-warning-500';
    }

    public function getColor(): string
    {
        return 'warning';
    }

    public function name(): string
    {
        return 'pending';
    }
}
