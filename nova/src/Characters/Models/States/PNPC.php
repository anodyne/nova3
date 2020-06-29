<?php

namespace Nova\Characters\Models\States;

class PNPC extends CharacterType
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
