<?php

namespace Nova\Characters\Models\States;

class NPC extends CharacterType
{
    public function color(): string
    {
        return '';
    }

    public function name(): string
    {
        return 'NPC';
    }
}
