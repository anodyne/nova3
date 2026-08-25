<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Status;

class Active extends CharacterStatus
{
    public static string $name = 'active';

    public function bgColor(): string
    {
        return 'bg-success-500';
    }

    public function getColor(): string
    {
        return 'success';
    }

    public function name(): string
    {
        return 'active';
    }
}
