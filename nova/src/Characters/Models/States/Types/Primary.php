<?php

namespace Nova\Characters\Models\States\Types;

class Primary extends CharacterType
{
    public function color(): string
    {
        return 'blue';
    }

    public function name(): string
    {
        return 'primary';
    }
}
