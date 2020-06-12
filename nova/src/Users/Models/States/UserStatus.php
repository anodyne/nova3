<?php

namespace Nova\Users\Models\States;

use Spatie\ModelStates\State;

abstract class UserStatus extends State
{
    abstract public function color(): string;

    abstract public function name(): string;

    public function displayName(): string
    {
        return ucfirst($this->name());
    }
}
