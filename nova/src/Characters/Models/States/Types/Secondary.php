<?php

namespace Nova\Characters\Models\States\Types;

class Secondary extends CharacterType
{
    public function color(): string
    {
        return 'purple';
    }

    public function name(): string
    {
        return 'secondary';
    }
}
