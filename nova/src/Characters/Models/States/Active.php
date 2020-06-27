<?php

namespace Nova\Characters\Models\States;

class Active extends CharacterStatus
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
