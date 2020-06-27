<?php

namespace Nova\Characters\Models\States;

use Spatie\ModelStates\State;

abstract class CharacterStatus extends State
{
    abstract public function color(): string;

    abstract public function name(): string;

    public function displayName(): string
    {
        return ucfirst($this->name());
    }
}
