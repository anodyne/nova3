<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Types;

class Support extends CharacterType
{
    public function color(): string
    {
        return 'gray';
    }

    public function name(): string
    {
        return 'support';
    }
}
