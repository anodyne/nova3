<?php

namespace Nova\Characters\Models\States\Types;

class Pnpc extends CharacterType
{
    public function color(): string
    {
        return 'info';
    }

    public function name(): string
    {
        return 'PNPC';
    }
}
