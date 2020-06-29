<?php

namespace Nova\Characters\Models\States;

class PlayingCharacter extends CharacterType
{
    public function color(): string
    {
        return 'success';
    }

    public function name(): string
    {
        return 'active';
    }
}
