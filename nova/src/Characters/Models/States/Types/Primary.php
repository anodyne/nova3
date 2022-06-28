<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Types;

class Primary extends CharacterType
{
    public static $name = 'primary';

    public function color(): string
    {
        return 'primary';
    }

    public function name(): string
    {
        return 'primary';
    }
}
