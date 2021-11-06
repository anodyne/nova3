<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Types;

class Secondary extends CharacterType
{
    public static $name = 'secondary';

    public function color(): string
    {
        return 'purple';
    }

    public function name(): string
    {
        return 'secondary';
    }
}
