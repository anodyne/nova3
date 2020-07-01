<?php

namespace Nova\Characters\Models\States;

class Npc extends CharacterType
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
